<?php

namespace App\Notifications\User;

use App\Models\EmailTemplate;
use App\Models\Roi;
use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class RoiReceivedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Roi $roi,
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
        $template = EmailTemplate::firstWhere('name', 'roi_received');
        $compiledTemplate = Blade::compileString($template->content);
        $renderedContent = Blade::render($compiledTemplate, [
            'profit' => $this->roi,
            'name' => $this->roi->user->name,
            'amount' => $this->roi->amount,
            'plan_name' => $this->roi->userPlan->plan->name,
            'created_at' => $this->roi->created_at,
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
        $template = EmailTemplate::firstWhere('name', 'roi_received');
        return [
            'message' => $this->message,
            'title' => $template->subject,
        ];
    }
}
