<?php

namespace App\Livewire\Admin\Settings;

use App\Models\EmailTemplate;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EmailTemplates extends Component
{
    use LivewireAlert;
    public $edit_email_verification_mail;

    public function mount(): void
    {
        $this->edit_email_verification_mail = Settings::select('edit_email_verification_mail')->find(1)->edit_email_verification_mail;
    }

    public function render()
    {
        return view('livewire.admin.settings.email-templates', [
            'templates' => EmailTemplate::where('status', 'active')->latest()->get(),
        ]);
    }

    public function pref(string $value): void
    {
        Settings::select(['id', 'edit_email_verification_mail'])->find(1)->update([
            'edit_email_verification_mail' => intval($value),
        ]);
        Cache::forget('site_settings');
        EmailTemplate::where('name', 'email_verification')->update([
            'status' => intval($value) === 1 ? 'active' : 'inactive',
        ]);
        $this->edit_email_verification_mail = intval($value);
        if (intval($value) === 1) {
            $this->alert(message: 'Click the pencil icon on Email verification template to edit it.');
        } else {
            $this->alert(message: 'Settings Saved Successfully.');
        }
    }
}