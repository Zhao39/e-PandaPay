<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class GeneralSettings extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $logo;
    public $logoo;
    public $favicon;
    public $faviconn;
    public $site_name;
    public $site_title;
    public $site_address;
    public $purchase_code;
    public $merchant_key;
    public $live_chat;
    public $timezone;
    public $install_type;
    public $admin_base_url;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function render()
    {
        $live_timezones = timezone_identifiers_list();
        include 'currencies.php';
        return view('livewire.admin.settings.general-settings', [
            'timezones' => $live_timezones,
        ]);
    }

    public function save(): void
    {
        $this->authorize('update general settings');
        $validated = $this->validate([
            'logoo' => ['nullable', 'sometimes', File::types(['jpg', 'jpeg', 'png'])->max('100mb')],
            'faviconn' => [
                'nullable',
                'sometimes',
                File::types(['jpg', 'jpeg', 'png', 'ico'])
                    ->max('50mb'),
            ],
            'site_name' => ['required'],
            'site_title' => ['required'],
            'site_address' => ['required'],
            'purchase_code' => ['nullable'],
            'merchant_key' => ['nullable'],
            'admin_base_url' => ['required', 'starts_with:/', 'regex:/^[a-zA-Z\/\-]*$/', 'lowercase', 'max:99'],
            'live_chat' => [
                'nullable',
                'string',
                'regex:/^(?!(<\s*script)|(<\s*\/\s*script))(.)*$/u',
            ],
            'timezone' => ['required'],
            'install_type' => ['required'],
        ]);

        $logo = $this->logo;
        $favicon = $this->favicon;

        if ($this->logoo) {
            $logo = $this->logoo->store(path: 'settings');
        }

        if ($this->faviconn) {
            $favicon = $this->faviconn->store(path: 'settings');
        }

        $this->logo = $logo;
        $this->favicon = $favicon;

        $this->set->update(array_merge(Arr::except($validated, ['logoo', 'faviconn']), ['logo' => $logo, 'favicon' => $favicon]));
        Cache::forget('site_settings');
        $this->reset(['logoo', 'faviconn']);
        activity()->log('General Settings Updated');
        if ($this->set->wasChanged('admin_base_url')) {
            $base = $this->admin_base_url;
            $this->flash(message: 'Settings saved successfully.', redirect: url("{$base}/settings/general"));
        } else {
            $this->alert(message: 'Settings saved successfully.');
        }
    }
}