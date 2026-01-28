<?php

namespace App\Livewire\Admin\Settings;

use App\Models\EmailTemplate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EmailTemplateEdit extends Component
{
    use LivewireAlert;

    public EmailTemplate $template;
    public $content;
    public $subject;
    public $inapp_notification_content;
    public function mount($template): void
    {
        $this->template = $template;
        $this->content = $this->template->content;
        $this->subject = $this->template->subject;
        $this->inapp_notification_content = $this->template->inapp_notification_content;
    }
    public function render()
    {
        return view('livewire.admin.settings.email-template-edit');
    }

    public function save(): void
    {
        // validate the form
        $this->validate([
            'content' => ['required'],
            'subject' => ['required'],
            'inapp_notification_content' => ['nullable', 'max:191'],
        ]);

        $this->template->update([
            'content' => $this->content,
            'subject' => $this->subject,
            'inapp_notification_content' => $this->inapp_notification_content,
        ]);
        activity()->log('Email Template Updated, template: ' . $this->template->name);
        $this->alert(message: 'Template updated successfully.');
    }
}
