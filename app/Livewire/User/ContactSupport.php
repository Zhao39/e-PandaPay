<?php

namespace App\Livewire\User;

use App\Mail\ContactAdminMail;
use App\Models\Faq;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ContactSupport extends Component
{
    use LivewireAlert;

    public $subject;
    public $message;
    public $search = '';

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        $faqs = Faq::latest()->search($this->search)->get();
        return view("{$template}.contact-support", compact('faqs'))
            ->extends("layouts.{$template}")
            ->title('Contact support');
    }

    public function send(): void
    {
        $this->validate([
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string'],
        ]);
        $user = auth()->user();
        $settings = Settings::select('id', 'notifiable_email')->find(1);
        // send email to admin
        Mail::to($settings->notifiable_email)->send(new ContactAdminMail($user->name, $user->email, $this->subject, $this->message));
        $this->alert(message: 'Message sent successfully.');
        $this->reset(['subject', 'message']);
    }
}
