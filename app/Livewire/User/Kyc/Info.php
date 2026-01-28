<?php

namespace App\Livewire\User\Kyc;

use App\Models\Settings;
use Livewire\Component;

class Info extends Component
{
    public function mount(): void
    {
        $settings = Settings::select('enable_kyc')->find(1);
        abort_if(! $settings->enable_kyc, 404);
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.kyc.info")
            ->extends("layouts.{$template}")
            ->title('Start KYC');
    }
}
