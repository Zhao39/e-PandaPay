<?php

namespace App\Livewire\Admin\Withdrawal;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\ProcessWithdrawalRequest;
use App\Models\PaymentMethod;
use App\Models\Settings;
use App\Models\Withdrawal;
use App\Notifications\User\WithdrawalFailedNotification;
use App\Notifications\User\WithdrawalProcessedNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProcessWithdrawal extends Component
{
    use LivewireAlert;

    public Withdrawal $withdrawal;
    public PaymentMethod $method;
    public $action = 'Paid';

    public function mount($id)
    {
        $this->withdrawal = Withdrawal::with('user')->find($id);
        $this->method = PaymentMethod::where('name', $this->withdrawal->payment_mode)->first();
    }

    public function render()
    {
        return view('livewire.admin.withdrawal.process-withdrawal');
    }

    public function processWithrdawal()
    {
        Gate::authorize('process withdrawals');

        $getEPandaPay = new GetEPandaPay();
        $request = new ProcessWithdrawalRequest([
            'proaction' => $this->action,
            'account_bal' => $this->withdrawal->user->account_bal,
            'deduction' => $this->withdrawal->to_deduct,
        ]);

        $response = $getEPandaPay->send($request);
        $data = json_decode($response->body(), true);

        if ($response->failed()) {
            $this->alert(type: 'warning', message: $data['message']);
            return;
        }

        try {
            $settings = Cache::get('site_settings');

            if ($data['data']['action']) {
                if ($settings->deduction_option === 'AdminApprove') {
                    $this->withdrawal->user()->update($data['data']['update']);
                }

                $this->withdrawal->status = 'processed';
                $this->withdrawal->save();

                if ($settings->send_withdrawal_email) {
                    // Send notification to user
                    $message = "Your withdrawal request of {$settings->currency}{$this->withdrawal->amount} was approved and funds have been sent to your selected account";
                    dispatch(function () use ($message) {
                        $this->withdrawal->user->notify(new WithdrawalProcessedNotification($this->withdrawal, $message));
                    })->afterResponse();
                }
            } else {
                if ($settings->deduction_option === 'userRequest') {
                    $this->withdrawal->user()->update($data['data']['update']);
                }

                $this->withdrawal->status = 'cancelled';
                $this->withdrawal->save();

                if ($settings->send_withdrawal_email) {
                    // Send notification to user
                    $message = "Your withdrawal request of {$settings->currency}{$this->withdrawal->amount} have been rejected";
                    dispatch(function () use ($message) {
                        $this->withdrawal->user->notify(new WithdrawalFailedNotification($this->withdrawal, $message));
                    })->afterResponse();
                }
            }
            Cache::forget('total_withdrawn');
            Cache::forget('chart_pendwithdraw');
            $this->flash(message: 'Action Sucessful!', redirect: route('admin.manageWithdrawal'));
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
}