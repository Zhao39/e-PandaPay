<?php

namespace App\Livewire\Admin\CopyTrade\Sub;

use App\Models\TradingAccount;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EditAccount extends Component
{
    use LivewireAlert;
    public $account;
    public $user_id;
    public $name;
    public $login;
    public $password;
    public $platform;
    public $account_type;
    public $currency;
    public $leverage;
    public $server;

    public function mount(string $id): void
    {
        $account = TradingAccount::find($id);
        $this->account = $account;
        $this->fill($account);
    }

    public function render()
    {
        return view('livewire.admin.copy-trade.sub.edit-account');
    }

    #[Computed()]
    public function users(): Collection
    {
        return User::isNotAdmin()->latest()->get();
    }

    public function save(): void
    {
        $this->authorize('manage subscribers');
        $validated = $this->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required'],
            'login' => ['required', 'string',  Rule::unique('trading_accounts')->ignore($this->account->id)],
            'password' => ['required'],
            'platform' => ['required'],
            'account_type' => ['required'],
            'currency' => ['required'],
            'leverage' => ['required'],
            'server' => ['required'],
        ]);
        $this->account->update(array_merge($validated, ['status' => 'pending']));
        $this->alert(message: ' Account Updated Successfully.');
        $this->reset();
        $this->dispatch('refresh-sub-accounts');
    }
}
