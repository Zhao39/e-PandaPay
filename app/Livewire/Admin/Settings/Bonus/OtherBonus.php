<?php

namespace App\Livewire\Admin\Settings\Bonus;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class OtherBonus extends Component
{
    use LivewireAlert;

    public $signup_bonus;
    public $deposit_bonus;
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
        $this->set->update($filtered);
        Cache::forget('site_settings');
        activity()->log('Other Bonus Settings Updated');
        $this->alert(message: 'Settings Saved Successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.bonus.other-bonus');
    }
}
