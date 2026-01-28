<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Services\TradeCopier;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Payment extends Component
{
    use LivewireAlert;

    public $myaccount;
    public $set;
    public $buy_slot = false;
    public $add_funds = false;
    public $slot;
    public $amount;
    public $fund_amount;
    public $toPay;

    public function mount(TradeCopier $copier): void
    {
        try {
            $this->set = $copier->settings();
        } catch (CopytradeErrorException $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function render(TradeCopier $copier)
    {
        try {
            $this->myaccount = $copier->profile();
        } catch (CopytradeErrorException $e) {
            session()->flash('message', $e->getMessage());
        }

        return view('livewire.admin.copy-trade.payment');
    }

    public function refreshProfile(): void
    {
        Cache::forget('account-profile');
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }

    public function setForBuy(): void
    {
        $this->buy_slot = true;
        $this->add_funds = false;
    }
    public function setForFund(): void
    {
        $this->buy_slot = false;
        $this->add_funds = true;
    }

    public function resetProps(): void
    {
        $this->reset([
            'buy_slot',
            'add_funds',
            'slot',
            'amount',
            'fund_amount',
            'toPay',
        ]);
    }

    public function calculateSlot(): void
    {
        $slot = $this->slot ? $this->slot : 0;
        $this->amount = $slot * floatval($this->set['amount_per_slot']);
    }

    public function purchaseSlot(TradeCopier $copier): void
    {
        $this->authorize('manage copytrade settings');
        $this->validate([
            'slot' => ['required', 'gt:0'],
        ]);
        try {
            $message = $copier->buySlot([
                'slot' => $this->slot,
                'amount' => $this->amount,
            ]);
            $this->alert(message: $message);
            $this->resetProps();
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function completePayment(TradeCopier $copier): void
    {
        $this->authorize('manage copytrade settings');

        $this->validate([
            'fund_amount' => ['required', 'gt:0'],
        ]);

        try {
            $message = $copier->addFunds([
                'amount' => $this->fund_amount,
            ]);
            $this->alert(message: $message);
            $this->resetProps();
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
