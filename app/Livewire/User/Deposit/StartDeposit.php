<?php

namespace App\Livewire\User\Deposit;

use App\Models\PaymentMethod;
use App\Models\Settings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class StartDeposit extends Component
{
    use LivewireAlert;

    public string $method;
    public Collection $methods;
    public string $amount;

    public function mount(): void
    {
        $this->methods = PaymentMethod::where(function ($query) {
            $query->where('type', 'deposit')
                ->orWhere('type', 'both');
        })->where('status', 'active')->latest()->get();

        // get the last payment method
        if ($this->methods->count() > 0) {
            $this->method = $this->methods->first()->name;
        }
    }
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.deposit.start-deposit")
            ->extends("layouts.{$template}")
            ->title('Make a Deposit');
    }

    public function submitPayment(): void
    {
        $spaMode = Settings::select('spa_mode')->find(1)->spa_mode;

        if (! auth()->user()->can_deposit) {
            $this->alert(type: 'error', message: 'You are not allowed to deposit, please contact support for more details');
            return;
        }
        try {
            $method = PaymentMethod::where('name', $this->method)->firstOrFail();
            session()->put('deposit_amount', $this->amount);
            $this->redirect(route('user.deposit.makepayment', ['method' => $method]), $spaMode ? true : false);
        } catch (ModelNotFoundException $e) {
            $this->alert(type: 'error', message: 'Payment method Not Found');
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: 'Something went wrong');
        }
    }
}
