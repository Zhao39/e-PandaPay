<?php

namespace App\Livewire\Admin\PlatformAdministration;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ShowAll extends Component
{
    public function render()
    {
        return view('livewire.admin.platform-administration.show-all');
    }
}
