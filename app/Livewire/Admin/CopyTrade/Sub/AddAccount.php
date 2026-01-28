<?php

namespace App\Livewire\Admin\CopyTrade\Sub;

use App\Models\TradingAccount;
use App\Models\User;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddAccount extends Component
{
    use LivewireAlert;

    public $user_id = null;
    public $name;
    public $login;
    public $password;
    public $platform = 'mt4';
    public $account_type;
    public $currency;
    public $leverage;
    public $server;
    public $cloudType = 'cloud-g2';
    #[Computed]
    public function users(): Collection
    {
        return User::isNotAdmin()->latest()->get();
    }


    public function render()
    {
        return view('livewire.admin.copy-trade.sub.add-account');
    }

    public function save(): void
    {
        $this->authorize('manage subscribers');
        $validated = $this->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required'],
            'login' => ['required'],
            'password' => ['required'],
            'platform' => ['required'],
            'account_type' => ['required'],
            'currency' => ['required'],
            'leverage' => ['required'],
            'server' => ['required'],
            'type' => $this->cloudType,
        ]);

        TradingAccount::create(array_merge($validated, ['status' => 'pending']));
        $this->alert(message: ' Account Created Successfully.');
        $this->reset();
        $this->dispatch('refresh-sub-accounts');
    }
}
