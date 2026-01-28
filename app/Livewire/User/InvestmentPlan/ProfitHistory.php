<?php

namespace App\Livewire\User\InvestmentPlan;

use App\Models\Settings;
use Livewire\Component;

class ProfitHistory extends Component
{
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.investment-plan.profit-history")
            ->extends("layouts.{$template}")
            ->title('Plan Profit History');
    }
}
