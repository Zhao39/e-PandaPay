<?php

namespace App\Livewire\User;

use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\User\TransferNotification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FundTransfer extends Component
{
    use LivewireAlert;
    public $show_password = false;
    public $password;
    public $amount;
    public $email;
    public $use_transfer;


    public function mount()
    {
        $use_transfer = Settings::select('use_transfer')->find(1)->use_transfer;
        $this->use_transfer = $use_transfer;
        abort_if(! $use_transfer, 404);
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.fund-transfer")
            ->extends("layouts.{$template}")
            ->title('Fund Transfer');
    }

    public function cancel()
    {
        $this->reset();
    }

    public function transfer()
    {
        abort_if(! $this->use_transfer, 401);

        $this->validate([
            'amount' => ['required', 'numeric', 'min:' . Settings::select('min_transfer')->find(1)->min_transfer],
            'email' => ['required'],
            'password' => ['required', 'current_password'],
        ]);

        $receiver = User::whereAny([
            'email',
            'username',
        ], $this->email)
            ->first();
        $user = User::find(auth()->user()->id);

        if (! $receiver) {
            $this->alert(type: 'error', message: 'No user with this email address or username exist');
            return;
        }

        if ($receiver->id === $user->id) {
            $this->alert(type: 'error', message: 'You cannot send funds to yourself');
            return;
        }

        $settings = Settings::find(1);
        $charges = floatval($this->amount) * $settings->transfer_charges / 100;
        $todeduct = floatval($this->amount) + $charges;

        if ($user->account_bal < $todeduct) {
            $this->alert(type: 'error', message: "Insufficient balance to send {$settings->currency}{$todeduct}");
            return;
        }

        // deduct balance from sender
        $user->account_bal -= $todeduct;
        $user->save();

        // credit balance to receiver
        $receiver->account_bal += $this->amount;
        $receiver->save();

        // //create history
        Transaction::create([
            'user_id' => $user->id,
            'narration' => "Transfered to {$receiver->name}",
            'amount' => $this->amount,
            'type' => 'Debit',
        ]);

        // //create history for receiver
        Transaction::create([
            'user_id' => $receiver->id,
            'narration' => "Transfer received from {$user->name}",
            'amount' => $this->amount,
            'type' => 'Credit',
        ]);

        $message = "You just received {$settings->currency}{$this->amount} from {$user->name} and your account balance have been credited accordingly.";
        dispatch(function () use ($receiver, $user, $message) {
            $receiver->notify(new TransferNotification($this->amount, $user->name, $receiver->name, now(), $message));
        })->afterResponse();

        $this->alert(message: "Successfully transferred {$settings->currency}{$this->amount} to {$receiver->name}");

        $this->reset();
    }
}
