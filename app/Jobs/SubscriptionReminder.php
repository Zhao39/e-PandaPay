<?php

namespace App\Jobs;

use App\Mail\GeneralMessageMail;
use App\Models\Settings;
use App\Models\TradingAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscriptions = TradingAccount::where('status', 'processed')->with('user')->whereNotNull('user_id')->get();
        $subscriptions->each(function (TradingAccount $account) {
            $today = now();
            $settings = Settings::select(['site_name', 'notifiable_email'])->find(1);

            if ($today->greaterThanOrEqualTo($account->end_date)) {
                //mark sub as expired
                $account->status = 'expired';
                $account->save();

                //send email to user
                $messageUser = "Your subscription with ID: {$account->login} have expired. To enable us continue trading on this account, please renew your subcription. \r\n To renew your subcription, login to your {$settings->site_name} account, go to copytradeing page and click on the renew button on the said account.";
                Mail::to($account->user->email)
                    ->queue(new GeneralMessageMail(
                        message: $messageUser,
                        sub: 'Your subscription have expired',
                        recipient_name: $account->user->name
                    ));

                // Send email to admin
                $messageAdmin = "Subscription with ID: {$account->login} have expired and the user have been notified.";
                Mail::to($settings->notifiable_email)->queue(new GeneralMessageMail(message: $messageAdmin, sub: 'Your subscription have expired', recipient_name: 'Admin'));
            }

            if ($today->isSameDay($account->reminded_at)) {
                // number of days for subscription to expire
                $daysLeft = $account->end_date->diffInDays($account->reminded_at);

                //send email to user
                $message = "Your subscription with MT4-ID: {$account->login} will expire in {$daysLeft} days. To avoid disconnection of your trading account, please renew your subcription before {$account->end_date}. \r\n To renew your subcription, login to your {$settings->site_name} account, go to copytrading page and click on the renew button on the said account.";
                Mail::to($account->user->email)
                    ->queue(new GeneralMessageMail(
                        message: $message,
                        sub: 'Your subscription will expire soon',
                        recipient_name: $account->user->name
                    ));
                $account->reminded_at = $account->reminded_at->addDay();
                $account->save();
            }
        });
    }
}
