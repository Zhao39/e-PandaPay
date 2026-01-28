<?php

namespace App\Livewire\User;

use App\Models\CryptoAccount;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPlan;
use App\Services\Website;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = User::find(auth()->user()->id);
        $settings = Settings::select(['theme', 'signup_bonus'])->find(1);

        $username = $user->username;
        $user->update([
            'refferal_link' => Website::url(true) . "/ref/{$username}",
        ]);

        CryptoAccount::firstOrCreate([
            'user_id' => $user->id,
        ]);

        if (! $user->received_signup_bonus && (! is_null($settings->signup_bonus) && $settings->signup_bonus > 0)) {
            $user->update([
                'bonus' => $user->bonus + $settings->signup_bonus,
                'account_bal' => $user->account_bal + $settings->signup_bonus,
                'received_signup_bonus' => true,
            ]);

            //create history
            Transaction::create([
                'user_id' => $user->id,
                'narration' => 'Signup Bonus',
                'amount' => $settings->signup_bonus,
                'type' => 'Credit',
            ]);
        }

        $template = $settings->theme;
        return view("{$template}.dashboard", [
            'plans' => UserPlan::where('user_id', auth()->user()->id)->with('plan')->latest()->take(5)->where('status', 'active')->get(),
            'history' => Transaction::where('user_id', auth()->user()->id)->latest()->take(7)->get(),
            'referrals' => User::where('reffered_by', auth()->user()->id)->count(),
        ])
            ->extends("layouts.{$template}")
            ->title('Dashboard');
    }
}
