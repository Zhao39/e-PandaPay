<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Models\EmailTemplate;
use App\Models\Settings;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Verified  $event
     *
     * @return void
     */
    public function handle(Verified $event)
    {
        $send_welcome_email = Settings::select('send_welcome_email')->find(1)->send_welcome_email;
        if ($send_welcome_email) {
            $user = $event->user;
            try {
                $template = EmailTemplate::firstWhere('name', 'welcome_email');
                Mail::to($user->email)->send(new WelcomeMail($user, $template));
            } catch (\Throwable $th) {
                logger($th->getMessage());
            }
        }
    }
}
