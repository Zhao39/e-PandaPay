<?php

namespace App\Livewire\Admin\Settings\Payment;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Coinbase extends Component
{
    use LivewireAlert;

    public $coinbase_apikey;
    public $coinbase_apiversion;
    public Settings $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->set = $settings;
        $this->fill($settings);
    }

    public function render()
    {
        return view('livewire.admin.settings.payment.coinbase');
    }

    public function save(): void
    {
        $this->set->update([
            'coinbase_apikey' => $this->coinbase_apikey,
            'coinbase_apiversion' => $this->coinbase_apiversion,
        ]);
        Cache::forget('site_settings');
        $this->alert(message: 'Coinbase Settings updated successfully.');
    }
}