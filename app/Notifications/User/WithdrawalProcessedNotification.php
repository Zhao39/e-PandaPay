<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\Settings;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class WithdrawalProcessedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Withdrawal $withdraw,
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
        $template = EmailTemplate::firstWhere('name', 'withdraw_processed');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'name' => $this->withdraw->user->name,
            'amount' => $this->withdraw->amount,
            'payment_mode' => $this->withdraw->payment_mode,
            'status' => $this->withdraw->status,
            'created_at' => $this->withdraw->created_at,
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
        $template = EmailTemplate::firstWhere('name', 'withdraw_processed');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
