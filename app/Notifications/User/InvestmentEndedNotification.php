<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\Settings;
use App\Models\UserPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class InvestmentEndedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected UserPlan $plan,
        protected readonly string $message
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $template = EmailTemplate::firstWhere('name', 'plan_ended');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'name' => $this->plan->user->name,
            'plan_name' => $this->plan->plan->name,
            'amount' => $this->plan->amount,
            'profit_earned' => $this->plan->profit_earned,
            'status' => $this->plan->status,
            'created_at' => $this->plan->created_at,
            'expire_date' => $this->plan->expire_date,
            'currency' => Settings::select('currency')->find(1)->currency,
        ]);
        return (new MailMessage())
            ->subject($template->subject)
            ->markdown('mail.user', ['content' => $renderedContent]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable)
    {
        $template = EmailTemplate::firstWhere('name', 'plan_ended');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
