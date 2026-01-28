<?php

namespace App\Livewire\Admin\CryptoSwap;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SwapSettings extends Component
{
    use LivewireAlert;

    public $use_api_price_for_swap;
    public $swap_fee;
    public $set;

    public function mount(): void
    {
        $set = Cache::get('site_settings');
        $this->fill($set);
        $this->set = $set;
    }

    public function render()
    {
        return view('livewire.admin.crypto-swap.swap-settings');
    }

    public function save(): void
    {
        $this->set->update([
            'use_api_price_for_swap' => $this->use_api_price_for_swap,
            'swap_fee' => $this->swap_fee,
        ]);
        Cache::forget('site_settings');
        $this->alert(message: 'Settings Saved Successfully');
    }
}