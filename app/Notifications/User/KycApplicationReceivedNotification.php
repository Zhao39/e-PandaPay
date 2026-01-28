<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\Kyc;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class KycApplicationReceivedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Kyc $kyc,
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
        $template = EmailTemplate::firstWhere('name', 'kyc_received');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'name' => $this->kyc->user->name,
            'first_name' => $this->kyc->first_name,
            'last_name' => $this->kyc->last_name,
            'email' => $this->kyc->email,
            'phone_number' => $this->kyc->phone_number,
            'address' => $this->kyc->address,
            'city' => $this->kyc->city,
            'state' => $this->kyc->state,
            'country' => $this->kyc->country,
            'status' => $this->kyc->status,
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
        $template = EmailTemplate::firstWhere('name', 'kyc_received');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
