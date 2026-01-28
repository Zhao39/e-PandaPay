<?php

namespace App\Livewire\Admin\ManageUsers;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\AccountAdjustment;
use App\Models\Transaction;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AdjustAccount extends Component
{
    use LivewireAlert;

    public $options = [
        'balance' => 'Account Balance',
        'Bonus' => 'Bonus',
        'Ref_Bonus' => 'Refferal Bonus',
        'Profit' => 'Profit (ROI)',
    ];
    public $column = 'balance';
    public $amount;
    public $adjustment = 'Credit';
    public $history = 'Yes';
    public User $user;

    public function render()
    {
        return view('livewire.admin.manage-users.adjust-account');
    }

    public function adjustAccount(): void
    {
        $this->authorize('edit user');
        if (
            $this->adjustment === 'Debit' &&
            $this->column === 'balance' &&
            ($this->user->account_bal < $this->amount)
        ) {
            $this->alert(type: 'warning', message: 'User Account Balance is insufficient for this operation.');
            return;
        }
        if (
            $this->adjustment === 'Debit' &&
            $this->column === 'Bonus' &&
            ($this->user->bonus < $this->amount)
        ) {
            $this->alert(type: 'warning', message: 'User Bonus is insufficient for this operation.');
            return;
        }

        if (
            $this->adjustment === 'Debit' &&
            $this->column === 'Ref_Bonus' &&
            ($this->user->ref_bonus < $this->amount)
        ) {
            $this->alert(type: 'warning', message: 'User Referral Bonus is insufficient for this operation.');
            return;
        }

        if (
            $this->adjustment === 'Debit' &&
            $this->column === 'Profit' &&
            ($this->user->roi < $this->amount)
        ) {
            $this->alert(type: 'warning', message: 'User Profit is insufficient for this operation.');
            return;
        }

        $GetEPandaPay = new GetEPandaPay();
        $request = new AccountAdjustment([
            'topUpType' => $this->adjustment,
            'userBalance' => $this->user->account_bal,
            'userRoi' => $this->user->roi,
            'userRef' => $this->user->ref_bonus,
            'userBonus' => $this->user->bonus,
            'type' => $this->column,
            'amount' => $this->amount,
        ]);

        $response = $GetEPandaPay->send($request);

        if ($response->failed()) {
            $error = json_decode($response->body());
            $this->alert(type: 'warning', message: $error->message);
            return;
        }
        $response = json_decode($response->body(), true);

        $this->user->update($response['data']['fixtures']);

        if ($this->history === 'Yes') {
            Transaction::create([
                'user_id' => $this->user->id,
                'narration' => "{$this->adjustment} {$this->user->name} account",
                'amount' => $this->amount,
                'type' => $this->adjustment,
            ]);
        }
        $this->reset(['amount', 'column', 'adjustment', 'history']);
        $this->dispatch('refreshp');
        $this->alert(message: 'Account Adjusted Successfully');
    }
}
