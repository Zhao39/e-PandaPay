<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use App\Notifications\Admin\LoginWithTwofactor;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.admin.auth.login');
    }

    public function store()
    {
        $validated = $this->validate([
            'email' => [
                'required',
                'email',
                'bail',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query->where('is_admin', true)->where('status', 'active');
                }),
            ],
            'password' => [
                'required',
            ],
        ]);

        if (Auth::attemptWhen($validated, function (User $user) {
            return $user->is_admin;
        })) {
            request()->session()->regenerate();
            $user = User::where('email', $this->email)->first();
            if ($user->enable_2fa) {
                $token = mt_rand(10000, 99999);
                $expired_at = now()->inUserTimezone()->addMinutes(10);
                $user->update([
                    'admin_two_factor_code' => $token,
                    'token_2fa_expiry' => $expired_at,
                    'pass_two_factor' => false,
                ]);
                // send email to admin.
                $user->notify(new LoginWithTwofactor($token, $expired_at->toDayDateTimeString()));
            }
            $ip = request()->ip();
            activity()->by($user)->log("Admin dashboard logged in to account from IP Address: {$ip}");
            return to_route('admin.dashboard');
        }
        session()->flash('error', 'Login details is invalid');
    }
}