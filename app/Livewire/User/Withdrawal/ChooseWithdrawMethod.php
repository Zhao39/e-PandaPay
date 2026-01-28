<?php

namespace App\Livewire\User\Withdrawal;

use App\Models\PaymentMethod;
use App\Models\Settings;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ChooseWithdrawMethod extends Component
{
    use LivewireAlert;
    public $request = false;
    public PaymentMethod $method;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.withdrawal.choose-withdraw-method", [
            'methods' => PaymentMethod::where(function ($query) {
                $query->where('type', 'withdrawal')
                    ->orWhere('type', 'both');
            })->where('status', 'active')->latest()->get(),
        ])
            ->extends("layouts.{$template}")
            ->title('Withdrawal request');
    }

    // cancel func

    #[On('complete_withdrawal')]
    public function cancel()
    {
        $this->request = false;
    }

    public function requestWithdrawal(string $id): void
    {
        if (! auth()->user()->can_withdraw) {
            $this->alert(type: 'error', message: 'You can not request withdrawal now, please contact support');
            return;
        }
        $this->method = PaymentMethod::find($id);
        $this->request = true;
    }
}
