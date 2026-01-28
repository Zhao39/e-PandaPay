<?php

namespace App\Livewire\User\CopyTrade;

use App\Mail\CopytradeMail;
use App\Models\Settings;
use App\Models\TradingAccount;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Show extends Component
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

    public function mount(): void
    {
        $settings = Settings::select(['monthlyfee', 'modules'])->find(1);
        abort_if($settings->modules['subscription'] !== 'true', 404);
        $this->amount = $settings->monthlyfee;
    }

    public function render(): View
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.copy-trade.show", [
            'accounts' => TradingAccount::with('user')->latest()->where('user_id', Auth::user()->id)->get(),
        ])
            ->extends("layouts.{$template}")
            ->title('Copytrade');
    }

    public function updatedDuration(): void
    {
        $settings = Settings::select('monthlyfee', 'quarterlyfee', 'yearlyfee')->find(1);

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
        ]));

        //create history
        Transaction::create([
            'user_id' => $user->id,
            'narration' => 'Subscribed MT4 Trading',
            'amount' => $this->amount,
            'type' => 'Debit',
        ]);

        $settings = Settings::select(['notifiable_email', 'receive_trade_account_submission_email'])->find(1);

        if ($settings->receive_trade_account_submission_email) {
            dispatch(function () use ($acnt, $settings) {
                Mail::to($settings->notifiable_email)->send(new CopytradeMail($acnt));
            })->afterResponse();
        }
        $this->reset();
        $this->alert(message: 'Successfully submitted your account, please wait for the system to validate your credentials');
    }

    public function renew(string $id): void
    {
        $account = TradingAccount::with('user')->find($id);

        if (! Gate::allows('renew-account', $account)) {
            abort(403);
        }

        $user = $account->user;

        $settings = Settings::select('monthlyfee', 'quarterlyfee', 'yearlyfee')->find(1);

        if ($account->duration === 'Monthly') {
            $amount = $settings->monthlyfee;
            $end_at = $account->end_date->addMonths(1);
        } elseif ($account->duration === 'Quarterly') {
            $amount = $settings->quarterlyfee;
            $end_at = $account->end_date->addMonths(4);
        } elseif ($account->duration === 'Yearly') {
            $amount = $settings->yearlyfee;
            $end_at = $account->end_date->addYears(1);
        }

        $remindAt = $end_at->subDays(10);

        if ($amount > $user->account_bal) {
            $this->alert(type: 'error', message: 'Your account balance is insufficient to renew your subscription, please make a deposit.');
            return;
        }

        // debit the user account balance
        $user->account_bal -= $amount;
        $user->save();

        // update the account info
        $account->start_date = now();
        $account->end_date = $end_at;
        $account->reminded_at = $remindAt;
        $account->status = 'processed';
        $account->save();

        // create transaction history
        Transaction::create([
            'user_id' => $user->id,
            'narration' => "Renewed MT4 Trading account: {$account->login}-{$account->name}",
            'amount' => $amount,
            'type' => 'Debit',
        ]);

        $this->alert(message: 'Your subcription have been renewed successfully.');
    }
}
