<?php

namespace App\Services;

use App\Mail\UserDepositedMail;
use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\Withdrawal;
use App\Notifications\User\DepositConfirmedNotification;
use App\Notifications\User\DepositSuccessfulNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(protected User $user) {}

    public function clearAccount(string $whatToClear): void
    {
        if ($whatToClear === 'account_bal') {
            $this->user->update(['account_bal' => 0]);
        }
        if ($whatToClear === 'roi') {
            $this->user->update(['roi' => 0]);
        }
        if ($whatToClear === 'bonus') {
            $this->user->update(['bonus' => 0]);
        }
        if ($whatToClear === 'ref_bonus') {
            $this->user->update(['ref_bonus' => 0]);
        }
        if ($whatToClear === 'deposits') {
            Deposit::where('user_id', $this->user->id)->delete();
        }
        if ($whatToClear === 'withdrawal') {
            Withdrawal::where('user_id', $this->user->id)->delete();
        }
        if ($whatToClear === 'transaction') {
            Transaction::where('user_id', $this->user->id)->delete();
        }
        if ($whatToClear === 'plans') {
            UserPlan::where('user_id', $this->user->id)->delete();
        }
    }

    public function deleteAccount(): bool
    {
        User::where('reffered_by', $this->user->id)->update(['reffered_by' => null]);
        if (! empty($this->user->profile_photo_path) && Storage::disk('public')->exists($this->user->profile_photo_path)) {
            Storage::disk('public')->delete($this->user->profile_photo_path);
        }
        $this->user->delete();
        return true;
    }

    public function saveDeposit(array $paymentData): void
    {
        $settings = Settings::select(['id', 'deposit_bonus', 'send_deposit_email', 'currency', 'receive_deposit_email', 'notifiable_email'])->find(1);

        DB::transaction(function () use ($paymentData, $settings) {
            // save deposit to database
            $deposit = Deposit::create($paymentData);

            if (! is_null($settings->deposit_bonus) && $settings->deposit_bonus > 0 && $paymentData['status'] === 'Processed') {
                $bonus = $paymentData['amount'] * $settings->deposit_bonus / 100;
                //create history
                Transaction::create([
                    'user_id' => $this->user->id,
                    'narration' => 'Deposit Bonus',
                    'amount' => $bonus,
                    'type' => 'Credit',
                ]);
            } else {
                $bonus = 0;
            }

            if ($paymentData['status'] === 'Processed') {
                // credit user account
                $this->user->update([
                    'bonus' => $this->user->bonus + $bonus,
                    'account_bal' => $this->user->account_bal + $bonus + $paymentData['amount'],
                ]);
                if (! empty($this->user->reffered_by)) {
                    (new ReferralCommisionService($this->user, $paymentData['amount']))->run();
                }
            }

            if ($settings->send_deposit_email && $paymentData['status'] === 'Processed') {
                $message = "Your deposit of {$settings->currency}{$paymentData['amount']} has been processed. Thank you";
                dispatch(function () use ($message, $deposit) {
                    $this->user->notify(new DepositConfirmedNotification($deposit, $message));
                })->afterResponse();
            }

            if ($settings->send_deposit_email && $paymentData['status'] === 'Pending') {
                $message = "We just received your deposit of {$settings->currency}{$paymentData['amount']}. We will process it shortly. Thank you";
                dispatch(function () use ($message, $deposit) {
                    $this->user->notify(new DepositSuccessfulNotification($deposit, $message));
                })->afterResponse();
            }

            if ($settings->receive_deposit_email) {
                dispatch(function () use ($settings, $deposit) {
                    Mail::to($settings->notifiable_email)->send(new UserDepositedMail($deposit));
                })->afterResponse();
            }
            Cache::forget('total_deposited');
            Cache::forget('chart_pendepsoit');
        });
    }

    public function confrimDeposit(string $deposit_id): void
    {
        $settings = Settings::select(['id', 'deposit_bonus', 'send_deposit_email', 'currency', 'receive_deposit_email', 'notifiable_email'])->find(1);

        DB::transaction(function () use ($deposit_id, $settings) {
            // save deposit to database
            $deposit = Deposit::find($deposit_id);
            $deposit->status = 'Processed';
            $deposit->save();

            $this->user = $deposit->user;

            if (! is_null($settings->deposit_bonus) && $settings->deposit_bonus > 0) {
                $bonus = $deposit->amount * $settings->deposit_bonus / 100;
                //create history
                Transaction::create([
                    'user_id' => $this->user->id,
                    'narration' => 'Deposit Bonus',
                    'amount' => $bonus,
                    'type' => 'Credit',
                ]);
            } else {
                $bonus = 0;
            }

            $this->user->update([
                'bonus' => $this->user->bonus + $bonus,
                'account_bal' => $this->user->account_bal + $bonus + $deposit->amount,
            ]);

            if (! empty($this->user->reffered_by)) {
                (new ReferralCommisionService($this->user, $deposit->amount))->run();
            }

            if ($settings->send_deposit_email) {
                $message = "Your deposit of {$settings->currency}{$deposit->amount} has been processed. Thank you";
                dispatch(function () use ($message, $deposit) {
                    $this->user->notify(new DepositConfirmedNotification($deposit, $message));
                })->afterResponse();
            }

            if ($settings->receive_deposit_email) {
                dispatch(function () use ($settings, $deposit) {
                    Mail::to($settings->notifiable_email)->send(new UserDepositedMail($deposit));
                })->afterResponse();
            }
            Cache::forget('total_deposited');
            Cache::forget('chart_pendepsoit');
        });
    }
}
