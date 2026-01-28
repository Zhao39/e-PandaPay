<?php

namespace App\Livewire\User\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Mail\CopytradeMail;
use App\Models\Settings;
use App\Models\TradingAccount;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TradeCopier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AccountDetails extends Component
{
    use LivewireAlert;
    public $duration = 'Monthly';
    public $amount;
    public $platform = 'MT4';
    public $login;
    public $password;
    public $name;
    public $account_type;
    public $server;
    public $leverage;
    public $currency;
    public $provider;

    public function mount(TradeCopier $copier, string $login): void
    {
        $settings = Settings::select(['id', 'monthlyfee', 'use_copytrade'])->find(1);
        abort_if(! $settings->use_copytrade, 404);
        $this->amount = $settings->monthlyfee;
        try {
            $providers = collect($copier->providers());
            $this->login = $login;
            $this->provider = $providers->first(fn ($provider) => $provider['login'] === $login);
        } catch (CopytradeErrorException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.copier.show'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.copier.show'));
        }
    }

    public function render()
    {
        $template = Settings::select('id', 'theme')->find(1)->theme;
        return view("{$template}.copy-trade.account-details", [])
            ->extends("layouts.{$template}")
            ->title('Account Details');
    }

    public function updatedDuration(): void
    {
        $settings = Settings::select('id', 'monthlyfee', 'quarterlyfee', 'yearlyfee')->find(1);

        if ($this->duration === 'Monthly') {
            $this->amount = $settings->monthlyfee;
        } elseif ($this->duration === 'Quarterly') {
            $this->amount = $settings->quarterlyfee;
        } elseif ($this->duration === 'Yearly') {
            $this->amount = $settings->yearlyfee;
        } else {
            $this->amount = null;
        }
    }

    public function addAccount(): void
    {
        if ($this->currency !== $this->provider['currency']) {
            $this->alert(type: 'warning', message: 'Please select the same currency as your copytrade account.');
            return;
        }

        if ($this->login === $this->provider['login']) {
            $this->alert(type: 'warning', message: 'Please use a different copytrade account.');
            return;
        }

        $val = $this->validate([
            'login' => ['required'],
            'password' => ['required'],
            'name' => ['required'],
            'account_type' => ['required'],
            'server' => ['required'],
            'leverage' => ['required'],
            'currency' => ['required'],
            'platform' => ['required'],
            'duration' => ['required'],
        ]);

        $user = User::find(Auth::user()->id);

        if ($this->amount > 0 && (floatval($this->amount) > $user->account_bal)) {
            $this->alert(type: 'error', message: 'Sorry, your account balance is insufficient for this request.');
            return;
        }

        if ($this->amount > 0) {
            $user->account_bal -= floatval($this->amount);
            $user->save();
        }

        $acnt = TradingAccount::create(array_merge($val, [
            'status' => 'pending',
            'user_id' => $user->id,
            'copying_trade' => false,
            'is_deployed' => false,
            'provider' => $this->provider['account_name'] . '-' . $this->provider['login'],
        ]));

        //create history
        Transaction::create([
            'user_id' => $user->id,
            'narration' => 'Subscribed MT4 Trading',
            'amount' => $this->amount,
            'type' => 'Debit',
        ]);

        $settings = Settings::select(['id', 'notifiable_email', 'receive_trade_account_submission_email'])->find(1);

        if ($settings->receive_trade_account_submission_email) {
            dispatch(function () use ($acnt, $settings) {
                Mail::to($settings->notifiable_email)->send(new CopytradeMail($acnt));
            })->afterResponse();
        }
        $this->flash(message: 'Successfully submitted your account, please wait for the system to validate your credentials', redirect: route('user.copier.show'));
    }
}
