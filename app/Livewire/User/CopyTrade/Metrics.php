<?php

namespace App\Livewire\User\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Models\Settings;
use App\Services\TradeCopier;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Metrics extends Component
{
    public $metrics;

    public function mount(TradeCopier $copier, $id): void
    {
        $settings = Settings::select(['use_copytrade'])->find(1);
        abort_if(! $settings->use_copytrade, 404);
        try {
            $this->metrics = $copier->accountMetrics($id);
        } catch (CopytradeErrorException $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.user.copy-trade.metrics');
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }
}
