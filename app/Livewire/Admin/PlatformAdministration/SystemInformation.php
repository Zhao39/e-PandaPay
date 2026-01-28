<?php

namespace App\Livewire\Admin\PlatformAdministration;

use App\Services\Website;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SystemInformation extends Component
{
    public function render()
    {
        return view('livewire.admin.platform-administration.system-information', [
            'hasSSL' => Website::hasHttps(),
        ]);
    }
}
