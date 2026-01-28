<?php

namespace App\Services;

use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReferralCommisionService
{
    protected User $user;
    protected float $amount;
    protected int $userId;
    protected int $level;

    public function __construct(User $user, float $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->level = 0;
    }

    public function run(): void
    {
        if (! empty($this->user->reffered_by) && DB::table('users')->where('id', $this->user->reffered_by)->exists()) {
            $this->creditDirectReferral();
            $this->creditDownline($this->amount, $this->user->id, $this->level);
        }
    }

    private function creditDirectReferral(): void
    {
        $settings = Settings::select(['id', 'referral_commission', 'currency'])->find(1);
        $earnings = $settings->referral_commission * $this->amount / 100;

        $referral = User::where('id', $this->user->reffered_by)->first();
        $referral->account_bal += $earnings;
        $referral->ref_bonus += $earnings;
        $referral->save();
        // history
        $this->createHistory($referral->id, $earnings);
    }

    // static function to calculate the referral commission
    private function creditDownline(float $amount, int $userId = 0, int $level = 0): void
    {
        $referedMembers = '';

        $users = User::isNotAdmin()->select(['id', 'account_bal', 'ref_bonus'])->get();

        $settings = Settings::select(['referral_commission1', 'referral_commission2', 'referral_commission3', 'referral_commission4', 'referral_commission5'])->find(1);

        $parent = User::where('id', $userId)->select(['reffered_by'])->first();

        $users->each(function (User $user) use ($level, $parent, $amount, $referedMembers, $settings) {
            if ($user->id === $parent->reffered_by) {
                if ($level === 1) {
                    $earnings = $settings->referral_commission1 * $amount / 100;
                    //add earnings to ancestor balance
                    $user->update([
                        'account_bal' => $user->account_bal + $earnings,
                        'ref_bonus' => $user->ref_bonus + $earnings,
                    ]);

                    $this->createHistory($user->id, $earnings, 'Level 1 Referral Bonus');
                } elseif ($level === 2) {
                    $earnings = $settings->referral_commission2 * $amount / 100;
                    //add earnings to ancestor balance
                    $user->update([
                        'account_bal' => $user->account_bal + $earnings,
                        'ref_bonus' => $user->ref_bonus + $earnings,
                    ]);

                    $this->createHistory($user->id, $earnings, 'Level 2 Referral Bonus');
                } elseif ($level === 3) {
                    $earnings = $settings->referral_commission3 * $amount / 100;
                    //add earnings to ancestor balance
                    $user->update([
                        'account_bal' => $user->account_bal + $earnings,
                        'ref_bonus' => $user->ref_bonus + $earnings,
                    ]);

                    $this->createHistory($user->id, $earnings, 'Level 3 Referral Bonus');
                } elseif ($level === 4) {
                    $earnings = $settings->referral_commission4 * $amount / 100;
                    //add earnings to ancestor balance
                    $user->update([
                        'account_bal' => $user->account_bal + $earnings,
                        'ref_bonus' => $user->ref_bonus + $earnings,
                    ]);

                    $this->createHistory($user->id, $earnings, 'Level 4 Referral Bonus');
                } elseif ($level === 5) {
                    $earnings = $settings->referral_commission5 * $amount / 100;
                    //add earnings to ancestor balance
                    $user->update([
                        'account_bal' => $user->account_bal + $earnings,
                        'ref_bonus' => $user->ref_bonus + $earnings,
                    ]);

                    $this->createHistory($user->id, $earnings, 'Level 5 Referral Bonus');
                }

                if ($level === 6) {
                    return false;
                }

                $referedMembers .= $this->creditDownline($amount, $user->id, $level + 1);
            }
        });
    }

    // save transaction history
    private function createHistory(int $userId, float $amount, string $narration = 'Direct Level Referral Bonus'): void
    {
        Transaction::create([
            'user_id' => $userId,
            'narration' => $narration,
            'amount' => $amount,
            'type' => 'Credit',
        ]);
    }
}
