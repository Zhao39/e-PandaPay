<?php

namespace App\Livewire\Pages;

use App\Mail\ContactAdminMail;
use App\Models\Content;
use App\Models\Page;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;

#[Layout('layouts.pages')]
class Contact extends Component
{
    use LivewireAlert;
    use UsesSpamProtection;

    public Page $page;
    public $name;
    public $email;
    public $message;
    public $subject;
    public HoneypotData $extraFields;

    public function mount()
    {
        $page = Page::where('name', 'Contact')->first();
        abort_if($page->status === 'draft', 404);
        $settings = Settings::select('redirect_url')->find(1);
        if (! empty($settings->redirect_url)) {
            return redirect()->away($settings->redirect_url);
        }
        $this->page = $page;
        $this->extraFields = new HoneypotData();
    }

    public function render()
    {
        return view('livewire.pages.contact', [
            'contents' => Content::all(),
        ]);
    }

    public function store(): void
    {
        $this->protectAgainstSpam();
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string'],
        ]);
        $settings = Settings::select('notifiable_email')->find(1);
        // send email to admin
        Mail::to($settings->notifiable_email)->send(new ContactAdminMail($validated['name'], $validated['email'], $validated['subject'], $validated['message']));
        session()->flash('success', 'Message sent successfully.');
        $this->reset(['name', 'email', 'subject', 'message']);
    }
}
