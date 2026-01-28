<?php

namespace App\Livewire\User\CryptoSwapping;

use App\Models\CryptoCurrency;
use App\Models\Settings;
use Livewire\Component;

class ViewCoin extends Component
{
    public CryptoCurrency $coin;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.crypto-swapping.view-coin")
            ->extends("layouts.{$template}")
            ->title($this->coin->name . ' Details');
    }
}
