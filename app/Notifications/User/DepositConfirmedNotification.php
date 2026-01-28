<?php

namespace App\Notifications\User;

use App\Models\Deposit;
use App\Models\EmailTemplate;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class DepositConfirmedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Deposit $deposit,
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
        $template = EmailTemplate::where('name', 'deposit_confirmed')->first();
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'name' => $this->deposit->user->name,
            'amount' => $this->deposit->amount,
            'payment_mode' => $this->deposit->payment_mode,
            'status' => $this->deposit->status,
            'created_at' => $this->deposit->created_at,
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
        $template = EmailTemplate::where('name', 'deposit_confirmed')->first();
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
