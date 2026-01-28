<?php

namespace App\Livewire\Admin\PlatformAdministration;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CronJob extends Component
{
    public function render()
    {
        // $path = '/usr/local/bin/php /home/{username}/{path-to-your-project}/artisan schedule:run';
        $path = '/usr/local/bin/php' . ' ' . request()->getHost() . '/artisan schedule:run';
        return view('livewire.admin.platform-administration.cron-job')->with('path', $path);
    }
}
