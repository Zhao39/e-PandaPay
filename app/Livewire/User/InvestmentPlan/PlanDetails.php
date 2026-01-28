<?php

namespace App\Livewire\User\InvestmentPlan;

use App\Models\Plan;
use App\Models\Roi;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserPlan;
use Illuminate\Support\Number;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PlanDetails extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $roiInfo;
    public UserPlan $plan;

    public function mount()
    {
        $this->setROiInfo($this->plan->plan);
    }
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.investment-plan.plan-details", [
            'roiHistory' => Roi::where('user_plan_id', $this->plan->id)->latest()->paginate(10),
        ])
            ->extends("layouts.{$template}")
            ->title('Plan Details');
    }

    public function cancelPlan(): void
    {
        $color = Settings::select('website_theme')->find(1)->website_theme;

        $this->alert(type: 'warning', message: 'Are you sure you want to cancel this plan?', options: [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'confirmButtonText' => 'Yes, Proceed',
            'position' => 'center',
            'onConfirmed' => 'cancel',
            'confirmButtonColor' => $color,
            'timer' => null,
        ]);
    }
    #[On('cancel')]
    public function cancel(): void
    {
        $this->plan->update(['status' => 'cancelled']);
        $this->alert(message: 'Plan canceled successfully');

        // credit the user his capital
        $this->plan->user()->update(['account_bal' => $this->plan->user->account_bal + $this->plan->amount]);

        //save to transactions history
        $th = new Transaction();
        $th->user_id = $this->plan->user_id;
        $th->amount = $this->plan->amount;
        $th->type = 'Credit';
        $th->narration = "Investment capital for cancelled plan {$this->plan->plan->name}";
        $th->save();
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
