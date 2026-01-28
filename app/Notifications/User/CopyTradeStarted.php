<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\TradingAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class CopyTradeStarted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected TradingAccount $account,
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
        $template = EmailTemplate::firstWhere('name', 'mt4_account');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'name' => $this->account->user->name,
            'account_type' => $this->account->account_type,
            'currency' => $this->account->currency,
            'leverage' => $this->account->leverage,
            'server' => $this->account->server,
            'duration' => $this->account->duration,
            'status' => $this->account->status,
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
        $template = EmailTemplate::firstWhere('name', 'mt4_account');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
