<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Twofactor extends Component
{
    public $admin_two_factor_code;
    public $token_2fa_expiry;

    public function mount()
    {
        $this->token_2fa_expiry = auth()->user()->token_2fa_expiry;
    }

    public function render()
    {
        return view('livewire.admin.auth.twofactor');
    }

    public function authorizeWithTwofa()
    {
        $this->validate([
            'admin_two_factor_code' => [
                'required',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query->where('id', auth()->user()->id)->where('admin_two_factor_code', $this->admin_two_factor_code);
                }),
            ],
        ]);

        if (now()->greaterThan($this->token_2fa_expiry)) {
            session()->flash('error', '2FA token has expired, please restart login.');
            return;
        }

        // update user two factor
        User::find(auth()->user()->id)->update([
            'admin_two_factor_code' => null,
            'token_2fa_expiry' => null,
            'pass_two_factor' => true,
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        $this->redirect('/admin/login');
    }
}
