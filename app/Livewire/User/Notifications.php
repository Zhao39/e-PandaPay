<?php

namespace App\Livewire\User;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;

    public function mount(): void
    {
        $this->user = User::find(auth()->user()->id);
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.notifications", [
            'notifications' => $this->user->notifications,
        ]);
    }

    public function markAsRead(string $notificationId): void
    {
        $this->user->notifications->where('id', $notificationId)->markAsRead();
        $this->dispatch('updateNotification');
    }

    // delete notification
    public function deleteNotification(string $notificationId): void
    {
        DB::table('notifications')->where('id', $notificationId)->delete();
        $this->dispatch('updateNotification');
    }

    // markAllAsRead
    public function markAllAsRead(): void
    {
        $this->user->unreadNotifications->markAsRead();
        $this->dispatch('updateNotification');
    }
}
