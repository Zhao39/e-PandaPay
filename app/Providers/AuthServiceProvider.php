<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\EmailTemplate;
use App\Models\Settings;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin'); // note this returns boolean
        });

        $edit_email_verification_mail = Settings::select('edit_email_verification_mail')->find(1)->edit_email_verification_mail;
        if ($edit_email_verification_mail) {
            $template = EmailTemplate::firstWhere('name', 'email_verification');
            VerifyEmail::toMailUsing(function (object $notifiable, string $url) use ($template) {
                $compiledTemplate = Blade::compileString($template->content);
                $renderedContent = Blade::render($compiledTemplate, [
                    'url' => $url,
                    'name' => $notifiable->name,
                ]);
                return (new MailMessage())
                    ->subject($template->subject)
                    ->markdown('mail.user', ['content' => $renderedContent]);
            });
        } else {
            VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
                return (new MailMessage())
                    ->subject('Verify Email Address')
                    ->line('Click the button below to verify your email address.')
                    ->action('Verify Email Address', $url);
            });
        }
    }
}