<?php

namespace App\Actions\Plan;

use App\Mail\UserPlanExpiredMail;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserPlan;
use App\Notifications\User\InvestmentEndedNotification;
use Illuminate\Support\Facades\Mail;

class MarkPlanAsExpiredAndReturnCapital
{
    public function __construct(public UserPlan $userPlan, public bool $returnCapital = false)
    {
    }

    public function process(): void
    {
        $userPlan = $this->userPlan;
        $user = $userPlan->user;
        $plan = $userPlan->plan;
        $settings = Settings::select(['id', 'return_capital', 'send_expired_plan_email', 'receive_expired_plan_email', 'notifiable_email'])->find(1);

        if ($settings->return_capital || $this->returnCapital) {
            $user->account_bal += $userPlan->amount;
            $user->save();

            //save to transactions history
            $th = new Transaction();
            $th->narration = "Investment capital returned for plan:{$plan->name}";
            $th->user_id = $user->id;
            $th->amount = $userPlan->amount;
            $th->type = 'Credit';
            $th->save();
        }

        //plan expiredP
        $userPlan->status = 'expired';
        $userPlan->save();

        if ($settings->send_expired_plan_email) {
            $message = "Your investment plan have expired. Plan: {$userPlan->plan->name}.";
            $user->notify(new InvestmentEndedNotification($userPlan, $message));
        }

        if ($settings->receive_expired_plan_email) {
            Mail::to($settings->notifiable_email)->send(new UserPlanExpiredMail($userPlan));
        }
    }
}
