<?php

namespace App\Livewire\User\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Models\Settings;
use App\Models\TradingAccount;
use App\Services\TradeCopier;
use Livewire\Component;

class SubAccountInfo extends Component
{
    public TradingAccount $account;
    public $metrics;

    public function mount(TradeCopier $copier): void
    {
        $settings = Settings::select(['use_copytrade'])->find(1);
        abort_if(! $settings->use_copytrade, 404);

        try {
            $this->metrics = $copier->accountMetrics($this->account->login);
        } catch (CopytradeErrorException) {
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.copy-trade.sub-account-info")
            ->extends("layouts.{$template}")
            ->title('Account Info');
    }
}
