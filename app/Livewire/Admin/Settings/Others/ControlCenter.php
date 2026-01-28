<?php

namespace App\Livewire\Admin\Settings\Others;

use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ControlCenter extends Component
{
    use LivewireAlert;

    public $admin_dashboard_logo_size;
    public $user_dashboard_logo_size;
    public $delete_records_older_than_days;
    public $auth_pages_logo_size;
    public $website_logo_size;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function save(): void
    {
        $array = $this->all();
        $filtered = Arr::except($array, ['set']);

        if ($this->set->admin_dashboard_logo_size === $this->admin_dashboard_logo_size) {
            $this->alert(message: 'Settings Saved Successfully.');
        } else {
            $this->flash(message: 'Settings Saved Successfully.', redirect: route('admin.settings.center'));
        }
        activity()->log('Control Center Settings Updated');
        $this->set->update($filtered);
        Cache::forget('site_settings');
    }

    public function render()
    {
        return view('livewire.admin.settings.others.control-center');
    }
}