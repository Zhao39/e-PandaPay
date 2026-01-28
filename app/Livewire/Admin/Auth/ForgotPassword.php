<?php

namespace App\Livewire\Admin\Auth;

use App\Mail\AdminResetPasswordMail;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.admin.auth.forgot-password');
    }

    public function sendPasswordRequest()
    {
        $this->validate([
            'email' => [
                'required', 'email', Rule::exists('users')->where(function (Builder $query) {
                    return $query->where('is_admin', true)->where('status', 'active');
                }),
            ],
        ]);

        $token = time();

        $admin = User::where('email', $this->email)->first();
        $admin->admin_two_factor_code = $token;
        $admin->save();

        Mail::to($admin->email)->send(new AdminResetPasswordMail(strval($token), $admin->name));

        return to_route('admin.auth.resetPassword', ['email' => $this->email])
            ->with('status', 'We just sent you an email containing a token to reset your password');
    }
}
