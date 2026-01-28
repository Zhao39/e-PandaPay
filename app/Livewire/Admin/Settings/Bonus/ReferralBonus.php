<?php

namespace App\Livewire\Admin\Settings\Bonus;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ReferralBonus extends Component
{
    use LivewireAlert;

    public $referral_commission;
    public $referral_commission1;
    public $referral_commission2;
    public $referral_commission3;
    public $referral_commission4;
    public $referral_commission5;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function save(): void
    {
        $this->validate([
            'referral_commission' => ['nullable', 'max:5'],
            'referral_commission1' => ['nullable', 'max:5'],
            'referral_commission2' => ['nullable', 'max:5'],
            'referral_commission3' => ['nullable', 'max:5'],
            'referral_commission4' => ['nullable', 'max:5'],
            'referral_commission5' => ['nullable', 'max:5'],
        ]);

        $array = $this->all();
        $filtered = Arr::except($array, ['set']);
        $this->set->update($filtered);
        Cache::forget('site_settings');
        activity()->log('Referral Bonus Settings Updated');
        $this->alert(message: 'Settings Saved Successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.bonus.referral-bonus');
    }
}