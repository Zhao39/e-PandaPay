<?php

namespace App\Jobs;

use App\Actions\Plan\MarkPlanAsExpiredAndReturnCapital;
use App\Models\Roi;
use App\Models\Settings;
use App\Models\UserPlan;
use App\Notifications\User\RoiReceivedNotification;
use App\Services\ReferralCommisionService;
use App\Services\RoiDateCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRoi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ?UserPlan $userPlan = null) {}
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UserPlan::where('status', 'active')
            ->with(['plan', 'user'])
            ->chunkById(200, function ($usersPlans) {
                foreach ($usersPlans as $userPlan) {
                    $now = now()->inUserTimezone();
                    $haveNotExpired = $now->lessThanOrEqualTo($userPlan->expire_date);
                    $hasExpired = $now->greaterThan($userPlan->expire_date);

                    $settings = Settings::find(1);

                    $plan = $userPlan->plan;
                    $user = $userPlan->user;

                    if ($haveNotExpired) {
                        $incrementValues = explode(',', $plan->increment_amount);
                        $value = $incrementValues[array_rand($incrementValues)];

                        if ($plan->increment_type === 'Percentage') {
                            $increment = intval($userPlan->amount) * floatval($value) / 100;
                        } else {
                            $increment = floatval($value);
                        }

                        if (is_null($userPlan->next_growth)) {
                            $growth = (new RoiDateCalculatorService())->getNextRoiDate($plan->increment_interval, $userPlan->activated_at);
                            $userPlan->next_growth = $growth;
                            $userPlan->save();
                        }
                        $nextGrowth = (new RoiDateCalculatorService())->getNextRoiDate($plan->increment_interval, now());

                        if ($settings->enable_trade_mode && $user->trade_mode && ($now->isWeekday() || $settings->enable_weekend_trade)) {
                            if ($now->greaterThanOrEqualTo($userPlan->next_growth)) {
                                //increment user account balance
                                $user->account_bal += $increment;
                                $user->roi += $increment;
                                $user->save();

                                // increment user plan profit earned
                                $userPlan->profit_earned += $increment;
                                $userPlan->next_growth = $nextGrowth;
                                $userPlan->save();

                                // create roi history
                                $roi = new Roi();
                                $roi->user_id = $user->id;
                                $roi->user_plan_id = $userPlan->id;
                                $roi->amount = $increment;
                                $roi->rate = floatval($value);
                                $roi->save();

                                // credit referral commission
                                if ($settings->referral_proffit_from === 'Profit') {
                                    (new ReferralCommisionService($user, $increment))->run();
                                }

                                if ($settings->send_roi_email) {
                                    $user->notify(new RoiReceivedNotification($roi, "You have a new profit. Plan: {$plan->name}, Amount: {$settings->currency}{$increment}"));
                                }
                            }
                        }

                        if (! $settings->enable_trade_mode || ! $user->trade_mode || ($now->isWeekend() && $settings->enable_trade_mode)) {
                            if ($now->greaterThanOrEqualTo($plan->next_growth)) {
                                $userPlan->next_growth = $nextGrowth;
                                $userPlan->save();
                            }
                        }
                    }

                    if ($hasExpired) {
                        //mark plan as expired and release capital
                        (new MarkPlanAsExpiredAndReturnCapital($userPlan))->process();
                    }
                }
            });
        echo 'Roi Processed Successfully';
    }
}