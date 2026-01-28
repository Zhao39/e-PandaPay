<?php

namespace App\Livewire\User\CryptoSwapping;

use App\Models\CryptoAccount;
use App\Models\CryptoCurrency;
use App\Models\Settings;
use Livewire\Component;

class Assets extends Component
{
    public $search = '';
    public $estimated_balance = 0;

    public function render()
    {
        if (! empty($this->search)) {
            $assets = CryptoCurrency::latest()->where('status', 'active')->whereAny(
                [
                    'name',
                    'symbol',
                ],
                'LIKE',
                "%{$this->search}%"
            )->get();
        } else {
            $assets = CryptoCurrency::latest()->where('status', 'active')->get();
        }
        $assets->transform(function (CryptoCurrency $asset) {
            $assets_balances = CryptoAccount::where('user_id', auth()->user()->id)->first();
            $symbol = strtolower($asset->symbol) . '_balance';
            $this->estimated_balance += $assets_balances->$symbol * $asset->price_in_usd;
            return [
                'asset' => $asset,
                'balance' => $assets_balances->$symbol,
            ];
        });
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.crypto-swapping.assets", compact('assets'))
            ->extends("layouts.{$template}")
            ->title('Swap crypto assets ');
    }
}
