<?php

namespace App\Livewire\User\InvestmentPlan;

use App\Models\Settings;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyPlans extends Component
{
    public $sort_value = 'All';

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.investment-plan.my-plans", [
            'plans' => UserPlan::where('user_id', Auth::user()->id)->with('plan')->status($this->sort_value)->latest()->get(),
        ])
            ->extends("layouts.{$template}")
            ->title('My investment plans');
    }
}
