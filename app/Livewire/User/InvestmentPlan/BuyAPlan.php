<?php

namespace App\Livewire\User\InvestmentPlan;

use App\Mail\UserInvestedMail;
use App\Models\Plan;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPlan;
use App\Notifications\User\InvestmentStartedNotification;
use App\Services\RoiDateCalculatorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Number;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BuyAPlan extends Component
{
    use LivewireAlert;

    public $planSelected;
    public $paymentMethod;
    public $disabled = true;
    public $amount;
    public $roiInfo;

    public function mount()
    {
        $settings = Settings::select('modules')->find(1);
        $options = $settings->modules;
        $use_investment = $options['investment'];

        abort_if($use_investment !== 'true', 404);

        $this->paymentMethod = 'Account Balance';
        $lastPlan = Plan::orderByDesc('id')->first();
        if ($lastPlan) {
            $this->planSelected = $lastPlan;
            $this->setROiInfo($this->planSelected);
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.investment-plan.buy-a-plan", [
            'plans' => Plan::latest()->get(),
        ])
            ->extends("layouts.{$template}")
            ->title('Buy an investment plan');
    }

    public function updatedAmount()
    {
        if (is_null($this->planSelected) || empty($this->amount)) {
            $this->disabled = true;
        } else {
            $this->disabled = false;
        }
        floatval($this->amount);
    }

    public function selectPlan(string $id)
    {
        $this->planSelected = Plan::find($id);
        $this->setROiInfo($this->planSelected);
        if (empty($this->amount) || ! $this->planSelected) {
            $this->disabled = true;
        } else {
            $this->disabled = false;
        }
    }

    public function joinPlan(RoiDateCalculatorService $roiDateCal): void
    {
        $this->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $plan = $this->planSelected;

        // setup
        $expiration = explode(' ', $plan->duration);
        $digit = $expiration[0];
        $frame = $expiration[1];
        $toexpire = 'add' . $frame;

        if ($digit === '1') {
            $end_at = now()->$toexpire();
        } else {
            $end_at = now()->$toexpire($digit);
        }
        $expiration = $end_at->addMinutes(5);

        $settings = Settings::select(['id', 'receive_buyplan_email', 'send_buyplan_email', 'currency', 'notifiable_email'])->find(1);

        if ($plan->status === 'inactive') {
            $this->alert(type: 'error', message: 'This plan is currently inactive. Please choose another plan');
            return;
        }

        if (empty($this->amount)) {
            $this->alert(type: 'error', message: 'Enter Amount to invest');
            return;
        }

        if ($this->amount < $plan->min_price) {
            $this->alert(type: 'error', message: "Minimum amount to invest is {$settings->currency}{$plan->min_price}");
            return;
        }

        if ($this->amount > $plan->max_price) {
            $this->alert(type: 'error', message: "Maximum amount to invest is {$settings->currency}{$plan->max_price}");
            return;
        }

        //check if the user account balance can buy this plan
        if ($user->account_bal < $this->amount) {
            $this->alert(type: 'error', message: 'Your account is insufficient to purchase this plan. Please make a deposit.');
            return;
        }

        // Credit user the plan bonus
        if ($plan->bonus > 0) {
            $user->account_bal += $plan->bonus;
            $user->bonus += $plan->bonus;
            $user->save();

            // create transaction history
            Transaction::create([
                'user_id' => $user->id,
                'narration' => "Plan Bonus for purchasing {$plan->name} plan",
                'amount' => $plan->bonus,
                'type' => 'Credit',
            ]);
        }

        //debit user
        if ($this->paymentMethod === 'Account Balance') {
            $user->account_bal -= $this->amount;
            $user->save();
        }

        //create history
        Transaction::create([
            'user_id' => $user->id,
            'narration' => "Purchased {$plan->name} plan",
            'amount' => $this->amount,
            'type' => 'Debit',
        ]);

        // calulate nextgroth
        $purchaseDate = now();
        $nextGrowth = $roiDateCal->getNextRoiDate($plan->increment_interval, now());

        //save user plan
        $userPlan = UserPlan::create([
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'amount' => $this->amount,
            'status' => 'active',
            'inv_duration' => $plan->duration,
            'activated_at' => $purchaseDate,
            'next_growth' => $nextGrowth,
            'expire_date' => $expiration,
        ]);

        //send notification
        try {
            if ($settings->send_buyplan_email) {
                $message = "You just purchased an investment plan: {$plan->name}, amount: {$settings->currency}{$this->amount}";
                dispatch(function () use ($user, $userPlan, $message) {
                    $user->notify(new InvestmentStartedNotification($userPlan, $message));
                })->afterResponse();
            }

            if ($settings->receive_buyplan_email) {
                dispatch(function () use ($settings, $userPlan) {
                    Mail::to($settings->notifiable_email)->send(new UserInvestedMail($userPlan));
                })->afterResponse();
            }
            $this->alert(message: 'You have successfully purchased a plan and your plan is now active.');

            $this->reset(['amount', 'disabled']);
        } catch (\Throwable) {
            $this->alert(type: 'warning', message: 'Plan purchase successful but failed to send email');
            $this->reset(['amount', 'disabled']);
        }
    }

    private function setROiInfo(Plan $planSelected)
    {
        $settings = Settings::select('s_currency')->find(1);
        $incrementValues = explode(',', $planSelected->increment_amount);

        if (count($incrementValues) > 1) {
            if ($planSelected->increment_type === 'Fixed') {
                $value =
                    Number::currency(floatval(min($incrementValues)), $settings->s_currency) .
                    ' - ' .
                    Number::currency(floatval(max($incrementValues)), $settings->s_currency);
            } else {
                $value =
                    Number::percentage(floatval(min($incrementValues)), 1) .
                    ' - ' .
                    Number::percentage(floatval(max($incrementValues)), 1);
            }
        } else {
            if ($planSelected->increment_type === 'Fixed') {
                $value = Number::currency(floatval($planSelected->increment_amount), $settings->s_currency);
            } else {
                $value = Number::percentage(floatval($planSelected->increment_amount), 1);
            }
        }

        $this->roiInfo = $value;
    }
}