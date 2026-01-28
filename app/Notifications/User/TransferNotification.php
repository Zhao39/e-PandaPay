<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class TransferNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $amount,
        protected string $sender,
        protected string $receiver,
        protected string $date_created,
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
        $template = EmailTemplate::firstWhere('name', 'transfer');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'amount' => $this->amount,
            'currency' => Settings::select('currency')->find(1)->currency,
            'created_at' => $this->date_created,
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
        $template = EmailTemplate::firstWhere('name', 'transfer');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
