<?php

namespace App\Livewire\Admin\Settings\Website;

use App\Models\Settings;
use App\Services\Website;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class WebSettings extends Component
{
    use LivewireAlert;

    public $redirect_url;
    public $show_plans_on_home_page;
    public $home_theme;
    public $site_in_maintenance_mode;
    public $maintenance_mode_token;
    public $facebook_social_link;
    public $x_social_link;
    public $instagram_social_link;
    public $mixedCase;
    public $numbers;
    public $symbols;
    public $letters;
    public $leastChar;
    public $uncompromised;
    public $set;

    public function mount(): void
    {

        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->mixedCase = $settings->password_validation_rules['mixedCase'] ?? false;
        $this->numbers = $settings->password_validation_rules['numbers'] ?? false;
        $this->symbols = $settings->password_validation_rules['symbols'] ?? false;
        $this->letters = $settings->password_validation_rules['letters'] ?? false;
        $this->leastChar = $settings->password_validation_rules['leastChar'] ?? 8;
        $this->uncompromised = $settings->password_validation_rules['uncompromised'] ?? false;
        $this->set = $settings;
    }

    public function render()
    {
        return view('livewire.admin.settings.website.web-settings', [
            'url' => Website::url(includeConnection: true),
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'redirect_url' => ['nullable', 'url'],
            'show_plans_on_home_page' => ['required'],
            'home_theme' => ['required'],
            'maintenance_mode_token' => ['nullable', 'required_if:site_in_maintenance_mode,1'],
        ]);

        if ((bool) $this->site_in_maintenance_mode) {
            try {
                Artisan::call('down', [
                    '--secret' => $this->maintenance_mode_token,
                    '--render' => 'errors::503',
                ]);
            } catch (\Throwable $th) {
                $this->alert(type: 'error', message: $th->getMessage());
            }
        }

        if ($this->set->site_in_maintenance_mode && ! (bool) $this->site_in_maintenance_mode) {
            Artisan::call('up');
        }

        $all = $this->all();
        $filtered = Arr::except($all, ['set', 'mixedCase', 'numbers', 'symbols', 'letters', 'leastChar', 'uncompromised']);
        $this->set->update($filtered);
        Cache::forget('site_settings');
        if ($this->site_in_maintenance_mode) {
            $this->redirect(route('admin.settings.website.settings'));
        } else {
            $this->alert(message: 'Settings Saved Successfully');
        }

        activity()->log('Website Settings Updated');
    }

    public function saveRules(): void
    {
        $settings = $this->set;
        $rules = [
            'mixedCase' => $this->mixedCase,
            'numbers' => $this->numbers,
            'symbols' => $this->symbols,
            'letters' => $this->letters,
            'leastChar' => $this->leastChar,
            'uncompromised' => $this->uncompromised,
        ];
        $settings->password_validation_rules = $rules;
        $settings->save();
        Cache::forget('site_settings');
        $this->alert(message: 'Password Rules Updated Successfully');

        activity()->log('Password validation Rules Updated');
    }
}