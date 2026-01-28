<?php

namespace App\Livewire\User\Withdrawal;

use App\Mail\WithdrawalOtpMail;
use App\Mail\WithdrawalRequestMail;
use App\Models\CoinPayment as ModelsCoinPayment;
use App\Models\PaymentMethod;
use App\Models\Settings;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\User\WithdrawalProcessedNotification;
use App\Notifications\User\WithdrawalSuccessNotification;
use App\Traits\Coinpayment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CompleteWithdrawal extends Component
{
    use LivewireAlert;
    use Coinpayment;

    public PaymentMethod $method;
    public $amount;
    public $otp;
    public $wallet_address;
    public $useotp = false;
    public $details;

    public function mount()
    {
        $this->useotp = Settings::select('id', 'enable_withdrawal_otp')->find(1)->enable_withdrawal_otp;
        $this->wallet_address = match ($this->method->name) {
            'Bitcoin' => auth()->user()->btc_address,
            'Ethereum' => auth()->user()->eth_address,
            'Litecoin' => auth()->user()->ltc_address,
            'USDT' => auth()->user()->usdt_address,
            default => null
        };
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.withdrawal.complete-withdrawal");
    }

    public function requestOtp(): void
    {
        $code = strtoupper($this->RandomStringGenerator(5));
        $user = User::find(auth()->user()->id);
        $user->withdrawal_otp = $code;
        $user->withdrawal_otp_expired_at = now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new WithdrawalOtpMail($user->name, $code));

        $this->alert(message: 'OTP has been sent to your email');
    }
    public function save(): void
    {
        $settings = Settings::where('id', '1')->first();
        $user = User::find(auth()->user()->id);

        if ($this->useotp && ($this->otp !== $user->withdrawal_otp || $user->withdrawal_otp_expired_at < now())) {
            $this->alert('error', 'Invalid OTP or OTP has expired');
            return;
        }

        if ($settings->enable_kyc && $user->account_verify !== 'verified') {
            $this->alert('error', 'You need to complete your account verification (KYC) first before you can place a withdrawal request.');
            return;
        }

        if ($this->method->charges_type === 'percentage') {
            $charges = floatval($this->amount) * $this->method->charges_amount / 100;
        } else {
            $charges = $this->method->charges_amount;
        }

        $to_withdraw = floatval($this->amount) + $charges;
        if ($user->account_bal < $to_withdraw) {
            $this->alert('error', 'Sorry, your account balance is insufficient for this request');
            return;
        }

        $min = $this->method->minimum;
        if (floatval($this->amount) < floatval($min)) {
            $this->alert('error', "Sorry, The minimum amount you can withdraw is {$settings->currency}{$min}, please try another payment method.");
            return;
        }

        $max = $this->method->maximum;
        if (floatval($this->amount) > floatval($max)) {
            $this->alert('error', "Sorry, The maximum amount you can withdraw is {$settings->currency}{$max}, please try with a lower amount");
            return;
        }

        if ($this->method->name === 'Bitcoin' && empty($user->btc_address)) {
            $this->alert('error', 'Please setup your Bitcoin wallet address');
            return;
        }
        if ($this->method->name === 'Ethereum' && empty($user->btc_address)) {
            $this->alert('error', 'Please setup your Ethereum wallet address');
            return;
        }

        if ($this->method->name === 'Litecoin' && empty($user->ltc_address)) {
            $this->alert('error', 'Please setup your Litecoin wallet address');
            return;
        }

        if ($this->method->name === 'USDT' && empty($user->usdt_address)) {
            $this->alert('error', 'Please setup your USDT wallet address');
            return;
        }

        if ($this->method->name === 'Bank Transfer') {
            if (empty($user->account_name) || empty($user->bank_name) || empty($user->account_number)) {
                $this->alert('error', 'Please setup your Bank Account Details');
                return;
            }
        }

        if ($settings->withdrawal_option === 'auto' && $this->method->methodtype === 'crypto') {
            try {
                $response = $this->cpwithdraw(floatval($this->amount), $this->method->coin, $this->wallet_address);
                if ($response['status'] === 'error') {
                    $this->alert('error', $response['message']);
                    return;
                }

                // //save withdrawal info
                $dp = new Withdrawal();
                $dp->user_id = $user->id;
                $dp->txn_id = $response['txn_id'];
                $dp->amount = $this->amount;
                $dp->to_deduct = $to_withdraw;
                $dp->payment_mode = "{$this->method->name}(CoinPayments)";
                $dp->status = 'Processed';
                $dp->save();

                // //store transacton details in DB
                $txn = new ModelsCoinPayment();
                $txn->txn_id = $response['txn_id'];
                $txn->item_name = 'Funds withdrawal';
                $txn->type = 'Withdrawal';
                $txn->amount_paid = $this->amount;
                $txn->user_id = $user->id;
                $txn->status = $response['payment_status'];
                $txn->currency1 = 'USD';
                $txn->currency2 = $this->method->coin;
                $txn->save();

                // debit user if deduction option is set to auto
                $user->account_bal -= $to_withdraw;
                $user->withdrawal_otp = null;
                $user->withdrawal_otp_expired_at = null;
                $user->save();

                $this->alert('success', 'Your withdrawal request has been processed. You will recieve your funds soon.');

                if ($settings->receive_withdrawal_email) {
                    dispatch(function () use ($settings, $dp) {
                        Mail::to($settings->notifiable_email)->send(new WithdrawalRequestMail($dp));
                    })->afterResponse();
                }

                if ($settings->send_withdrawal_email) {
                    $message = "Your withdrawal request of {$settings->currency}{$this->amount} via {$this->method->name} has been processed.";
                    dispatch(function () use ($dp, $user, $message) {
                        $user->notify(new WithdrawalProcessedNotification($dp, $message));
                    })->afterResponse();
                }
                $this->reset([
                    'amount',
                    'wallet_address',
                    'details',
                    'otp',
                    'useotp',
                ]);

                $this->dispatch('complete_withdrawal');
                return;
            } catch (\Throwable $th) {
                $this->alert('error', $th->getMessage());
                return;
            }
        }

        //debit user if deduction option is set to userRequest
        if ($settings->deduction_option === 'userRequest') {
            $user->account_bal -= $to_withdraw;
            $user->withdrawal_otp = null;
            $user->withdrawal_otp_expired_at = null;
            $user->save();
        }

        // //save withdrawal info
        $dp = new Withdrawal();
        $dp->user_id = $user->id;
        $dp->amount = $this->amount;
        $dp->to_deduct = $to_withdraw;
        $dp->payment_mode = $this->method->name;
        $dp->status = 'pending';
        $dp->paydetails = $this->wallet_address . $this->details;
        $dp->save();

        // // send mail to admin
        if ($settings->receive_withdrawal_email) {
            dispatch(function () use ($settings, $dp) {
                Mail::to($settings->notifiable_email)->send(new WithdrawalRequestMail($dp));
            })->afterResponse();
        }

        try {
            if ($settings->send_withdrawal_email) {
                $message = "Your withdrawal request of {$settings->currency}{$this->amount} via {$this->method->name} has been submitted. Please wait while we process your request";
                dispatch(function () use ($dp, $user, $message) {
                    $user->notify(new WithdrawalSuccessNotification($dp, $message));
                })->afterResponse();
            }
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: 'Something went wrong. Please try again');
            return;
        }

        $this->reset([
            'amount',
            'wallet_address',
            'details',
            'otp',
            'useotp',
        ]);
        $this->dispatch('complete_withdrawal');
        Cache::forget('chart_pendwithdraw');
        Cache::forget('total_withdrawn');
        $this->alert(message: 'Action Sucessful! Please wait while we process your request');
    }

    private function RandomStringGenerator($n)
    {
        $generated_string = '';
        $domain = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string .= $domain[$index];
        }
        // Return the random generated string
        return $generated_string;
    }
}
