<?php

namespace App\Livewire\User\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Models\Settings;
use App\Services\TradeCopier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MasterAccounts extends Component
{
    use LivewireAlert;

    public $providers;

    public function mount(TradeCopier $copier): void
    {
        $settings = Settings::select(['id', 'use_copytrade'])->find(1);
        abort_if(! $settings->use_copytrade, 404);
        try {
            $this->providers = $copier->providers();
        } catch (CopytradeErrorException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.copier.show'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.copier.show'));
        }
    }

    public function render()
    {
        $template = Settings::select('id', 'theme')->find(1)->theme;
        return view("{$template}.copy-trade.master-accounts", [])
            ->extends("layouts.{$template}")
            ->title('Providers Accounts');
    }
}
