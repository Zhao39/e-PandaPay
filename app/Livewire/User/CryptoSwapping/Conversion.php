<?php

namespace App\Livewire\User\CryptoSwapping;

use App\Models\CryptoAccount;
use App\Models\CryptoCurrency;
use App\Models\CryptoRecord;
use App\Models\Settings;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Conversion extends Component
{
    use LivewireAlert;

    public CryptoCurrency $coin;
    public CryptoCurrency $from_currency;
    public $symbol;
    public $from_is_account_balance = true;
    public CryptoCurrency $to_currency;
    public $to_is_account_balance = false;
    public $to_amount;
    public $from_amount;
    public $quantity;
    public $from_balance;
    public $to_balance;
    public User $user;
    public CryptoAccount $user_account;
    public $to_deduct;
    public function mount()
    {
        $this->user = User::find(auth()->user()->id);
        $this->from_balance = $this->user->account_bal;
        $this->to_currency = $this->coin;
        $account = CryptoAccount::where('user_id', auth()->user()->id)->first();
        $this->user_account = $account;
        $symbol = strtolower($this->coin->symbol) . '_balance';
        $this->to_balance = $account->$symbol;
        $this->symbol = $this->coin->symbol;
    }

    public function render()
    {
        $assets = CryptoCurrency::latest()->where('status', 'active')->get();
        $assets->transform(function (CryptoCurrency $asset) {
            $assets_balances = CryptoAccount::where('user_id', auth()->user()->id)->first();
            $symbol = strtolower($asset->symbol) . '_balance';
            return [
                'asset' => $asset,
                'balance' => $assets_balances->$symbol,
            ];
        });
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.crypto-swapping.conversion", compact('assets'))
            ->extends("layouts.{$template}")
            ->title($this->coin->name . ' Swap');
    }

    public function selectFromAsset(string $asset): void
    {
        if ($asset === 'Account Balance') {
            $this->from_is_account_balance = true;
            $this->from_balance = $this->user->account_bal;
            $this->from_amount = null;
            $this->to_amount = null;
            return;
        }
        $currency = CryptoCurrency::where('symbol', $asset)->first();
        $account = CryptoAccount::where('user_id', auth()->user()->id)->first();
        $symbol = strtolower($currency->symbol) . '_balance';
        $this->from_currency = $currency;
        $this->from_is_account_balance = false;
        $this->from_balance = $account->$symbol;
        $this->symbol = $currency->symbol;
        $this->from_amount = null;
        $this->to_amount = null;
    }

    public function selectToAsset(string $asset): void
    {
        if ($asset === 'Account Balance') {
            $this->to_is_account_balance = true;
            $this->to_balance = $this->user->account_bal;
            $this->from_amount = null;
            $this->to_amount = null;
            return;
        }
        $currency = CryptoCurrency::where('symbol', $asset)->first();
        $account = CryptoAccount::where('user_id', auth()->user()->id)->first();
        $symbol = strtolower($currency->symbol) . '_balance';
        $this->to_currency = $currency;
        $this->to_is_account_balance = false;
        $this->to_balance = $account->$symbol;
        $this->symbol = $currency->symbol;
        $this->from_amount = null;
        $this->to_amount = null;
    }

    public function calculate(): void
    {
        $swapFee = Settings::select('swap_fee')->find(1)->swap_fee;
        $pluscharge = floatval($this->from_amount) * $swapFee / 100;
        $amount = floatval($this->from_amount) + $pluscharge;
        $this->to_deduct = $amount;

        if ($this->from_is_account_balance && $this->to_is_account_balance) {
            $this->to_amount = $this->from_amount;
            return;
        }

        if (! $this->from_is_account_balance && ! $this->to_is_account_balance) {
            if ($this->from_currency->symbol === $this->to_currency->symbol) {
                $this->to_amount = $this->from_amount;
                return;
            }
        }

        if ($this->from_is_account_balance && ! $this->to_is_account_balance) {
            if ($this->from_amount) {
                $this->to_amount = round($this->from_amount / floatval($this->to_currency->price_in_usd), 8);
            } else {
                $this->to_amount = null;
            }
        }

        if (! $this->from_is_account_balance && $this->to_is_account_balance) {
            if ($this->from_amount) {
                $this->to_amount = round($this->from_amount * floatval($this->from_currency->price_in_usd), 8);
            } else {
                $this->to_amount = null;
            }
        }

        if (! $this->from_is_account_balance && ! $this->to_is_account_balance) {
            if ($this->from_amount) {
                $base = floatval($this->from_currency->price_in_usd);
                $quote = floatval($this->to_currency->price_in_usd);
                $this->to_amount = round($this->from_amount * $base / $quote, 8);
            } else {
                $this->to_amount = null;
            }
        }
    }
    public function convert(): void
    {
        $this->validate([
            'from_amount' => ['gt:0'],
        ]);

        if ($this->from_is_account_balance && $this->to_is_account_balance) {
            $this->alert('warning', 'You cannot convert from your account balance to your account balance.');
            return;
        }

        if (! $this->from_is_account_balance && ! $this->to_is_account_balance) {
            if ($this->from_currency->symbol === $this->to_currency->symbol) {
                $this->alert('warning', 'You cannot convert from the same currency.');
                return;
            }
        }

        if ($this->from_is_account_balance && $this->to_deduct > $this->user->account_bal) {
            $this->alert('warning', 'Your account balance is insufficient to complete this transaction. Note Charges is included.');
            return;
        }

        if (! $this->from_is_account_balance && $this->to_deduct > $this->from_balance) {
            $this->alert('warning', 'Your account balance is insufficient to complete this transaction. Note Charges is included.');
            return;
        }

        if ($this->from_is_account_balance) {
            // debit user account balance
            $this->user->account_bal -= $this->to_deduct;
            $this->user->save();
            // credit crypto account
            $symbol = strtolower($this->to_currency->symbol) . '_balance';
            $this->user_account->$symbol += $this->to_amount;
            $this->user_account->save();

            $source = 'Account Balance';
            $destination = "{$this->to_currency->name}({$this->to_currency->symbol})";
        }

        if (! $this->from_is_account_balance && ! $this->to_is_account_balance) {
            $symbolbase = strtolower($this->from_currency->symbol) . '_balance';
            $symbol = strtolower($this->to_currency->symbol) . '_balance';
            $this->user_account->$symbolbase -= $this->to_deduct;
            $this->user_account->$symbol += $this->to_amount;
            $this->user_account->save();

            $source = "{$this->from_currency->name}({$this->from_currency->symbol})";
            $destination = "{$this->to_currency->name}({$this->to_currency->symbol})";
        }

        if (! $this->from_is_account_balance && $this->to_is_account_balance) {
            //dd($this->to_amount);
            // debit crypto account
            $symbol = strtolower($this->to_currency->symbol) . '_balance';
            $this->user_account->$symbol -= $this->to_deduct;
            $this->user_account->save();

            // crddit user account balance
            $this->user->account_bal += $this->to_amount;
            $this->user->save();

            $source = "{$this->from_currency->name}({$this->from_currency->symbol})";
            $destination = 'Account Balance';
        }

        // create transaction history
        $rcd = new CryptoRecord();
        $rcd->user_id = $this->user->id;
        $rcd->source = $source;
        $rcd->dest = $destination;
        $rcd->amount = $this->from_amount;
        $rcd->quantity = $this->to_amount;
        $rcd->save();

        $this->flash(message: 'Conversion Completed Successfully.', redirect: route('user.swap.assets'));
    }
}
