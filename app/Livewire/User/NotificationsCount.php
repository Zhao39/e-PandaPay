<?php

namespace App\Livewire\User;

use App\Models\Settings;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationsCount extends Component
{
    #[On('updateNotification')]
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.notifications-count", [
            'notificationsCount' => auth()->user()->unreadNotifications->count(),
        ]);
    }
}
