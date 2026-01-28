<?php

namespace App\Livewire\Admin\SignalProvider;

use App\Exceptions\SignalErrorException;
use App\Models\Settings;
use App\Models\User;
use App\Services\SignalService;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SignalSubscribers extends Component
{
    use LivewireAlert;

    public $subscribers;
    public $page;
    public $nextPageUrl;
    public $previousPageUrl;
    public $subscriber_id;

    public function mount(string $page): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['signal'] !== 'true', 404);
        $this->page = $page;
    }

    public function render(SignalService $signal)
    {
        try {
            $data = $signal->subscribers($this->page);
            $subscribers = collect($data['data'])->map(function (array $item) {
                $user = User::find($item['client_id']);
                return [
                    'id' => $item['id'],
                    'user_id' => $item['client_id'],
                    'user' => $user ? $user->name : '-',
                    'subscription' => $item['subscription'],
                    'status' => $item['status'],
                    'amount_paid' => $item['amount_paid'],
                    'expired_at' => Carbon::parse($item['expired_at']),
                    'created_at' => Carbon::parse($item['created_at']),
                ];
            });

            $this->subscribers = $subscribers;
            $this->nextPageUrl = $data['next_page_url'];
            $this->previousPageUrl = $data['prev_page_url'];
        } catch (SignalErrorException $e) {
            session()->flash('message', $e->getMessage());
        }
        return view('livewire.admin.signal-provider.signal-subscribers');
    }

    public function deleteSub(SignalService $signal, string $id, string $user_id): void
    {
        $this->authorize('manage subscribers');
        try {
            $msg = $signal->deleteSubscriber($id, $user_id);
            $this->alert(message: $msg);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function ban(SignalService $signal, string $id): void
    {
        $this->authorize('manage subscribers');
        try {
            $message = $signal->subscriberBan([
                'id' => $id,
                'ban_type' => 'banChatMember',
            ]);
            $this->alert(message: $message);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function unBan(SignalService $signal, string $id): void
    {
        $this->authorize('manage subscribers');
        try {
            $message = $signal->subscriberBan([
                'id' => $id,
                'ban_type' => 'unbanChatMember',
            ]);
            $this->alert(message: $message);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
