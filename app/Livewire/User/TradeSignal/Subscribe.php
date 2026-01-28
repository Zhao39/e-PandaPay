<?php

namespace App\Livewire\User\TradeSignal;

use App\Exceptions\SignalErrorException;
use App\Mail\SignalSubscriptionMail;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\User\SignalSubscriptionSuccessful;
use App\Services\SignalService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Subscribe extends Component
{
    use LivewireAlert;

    public $duration = 'Choose';
    public $amount;
    public $expire;
    public $telegram_id;
    public $hasSubscribe = false;
    public $inviteLink;
    public $monthly;
    public $yearly;
    public $quarterly;

    public function mount(SignalService $signal)
    {
        try {
            $settings = $signal->settings();
            $this->monthly = $settings['signal_monthly_fee'];
            $this->yearly = $settings['signal_yearly_fee'];
            $this->quarterly = $settings['signal_quartly_fee'];
        } catch (SignalErrorException) {
            $this->flash(type: 'error', message: 'Something went wrong, please try again or contact support');
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.trade-signal.subscribe");
    }

    public function updatedDuration()
    {
        if ($this->duration === 'Monthly') {
            $this->amount = $this->monthly;
            $this->expire = now()->addMonth();
        } elseif ($this->duration === 'Quarterly') {
            $this->amount = $this->quarterly;
            $this->expire = now()->addQuarter();
        } elseif ($this->duration === 'Yearly') {
            $this->amount = $this->yearly;
            $this->expire = now()->addYear();
        } else {
            $this->amount = '';
            unset($this->expire);
        }
    }

    public function subscribe(SignalService $signal)
    {
        $this->validate([
            'telegram_id' => ['required'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);

        $user = User::find(Auth::user()->id);

        if ($user->account_bal < floatval($this->amount)) {
            $this->alert(type: 'error', message: 'Insufficient funds in your account balance to perform this action');
            return;
        }

        try {
            $sub = $signal->subscribe([
                'id' => $user->id,
                'duration' => $this->duration,
                'amount' => $this->amount,
                'expire' => $this->expire,
                'telegram_user_id' => $this->telegram_id,
            ]);

            //debit user
            $user->account_bal -= floatval($this->amount);
            $user->save();

            $this->inviteLink = $sub['inviteLink'];
            $this->hasSubscribe = $sub['hasSubscribe'];

            $settings = Settings::select(['id', 'notifiable_email', 'receive_signal_subscribe_email', 'send_signal_subscribe_email'])->find(1);

            if ($settings->send_signal_subscribe_email) {
                dispatch(function () use ($user) {
                    $user->notify(new SignalSubscriptionSuccessful($this->duration, $this->amount, $this->expire, 'You have succesfully subscribed to trading signal'));
                })->afterResponse();
            }
            if ($settings->receive_signal_subscribe_email) {
                dispatch(function () use ($user, $settings) {
                    Mail::to($settings->notifiable_email)->send(new SignalSubscriptionMail([
                        'name' => $user->name,
                        'duration' => $this->duration,
                        'created_at' => now(),
                    ]));
                })->afterResponse();
            }
            $this->alert(message: 'You have succesfully subscribed to trading signal');
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }
}
