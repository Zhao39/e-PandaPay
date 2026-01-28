<?php

namespace App\Livewire\Admin\ManageDeposits;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\AccountAdjustment;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddDeposit extends Component
{
    use LivewireAlert;
    public $amount;
    public $addToBalance = 1;
    public $userId;

    #[Computed()]
    public function users(): Collection
    {
        return User::isNotAdmin()->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.manage-deposits.add-deposit');
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }

    public function save(): void
    {
        $this->authorize('manually create deposit');
        $this->validate([
            'userId' => ['exists:users,id'],
        ]);
        $user = User::find($this->userId);

        $GetEPandaPay = new GetEPandaPay();
        $request = new AccountAdjustment([
            'user' => $user->id,
            'topUpType' => 'Credit',
            'userBalance' => $user->account_bal,
            'userRoi' => $user->roi,
            'userRef' => $user->ref_bonus,
            'userBonus' => $user->bonus,
            'type' => 'Deposit',
            'amount' => $this->amount,
        ]);

        $response = $GetEPandaPay->send($request);

        if ($response->failed()) {
            $error = json_decode($response->body());
            $this->alert(type: 'warning', message: $error->message);
            return;
        }
        $response = json_decode($response->body(), true);

        Deposit::create($response['data']['fixtures']);

        Cache::forget('total_deposited');
        Cache::forget('chart_pendepsoit');
        if ((bool) $this->addToBalance) {
            $user->update($response['data']['min_fixtures']);
        }

        $this->reset('amount', 'userId', 'addToBalance');
        $this->alert(message: 'Deposit record created successfully.');
        $this->dispatch('close-deposit-modal');
    }
}
