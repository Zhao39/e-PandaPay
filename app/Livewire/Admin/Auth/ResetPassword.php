<?php

namespace App\Livewire\Admin\Auth;

use App\Mail\AdminResetPasswordSuccessfulMail;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ResetPassword extends Component
{
    public User $admin;
    public string $email;
    public $token;
    public $password;
    public $password_confirmation;

    public function mount($email)
    {
        try {
            $this->admin = User::where('email', $email)->firstOrFail();
            if (is_null($this->admin->admin_two_factor_code)) {
                return to_route('admin.auth.forgotPassword')->with('error', 'Enter your email address to reset password');
            }
            $this->email = $email;
        } catch (ModelNotFoundException) {
            return to_route('admin.auth.forgotPassword')->with('error', 'Invalid email address');
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.reset-password');
    }

    // Validate token
    public function resetPassword()
    {
        $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'exists:users,admin_two_factor_code'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('email', $this->email)->first();
        $user->password = Hash::make($this->password);
        $user->admin_two_factor_code = null;
        $user->save();

        Mail::to($user->email)->send(new AdminResetPasswordSuccessfulMail());
        return to_route('admin.auth.login')->with('success', 'Password Reset successful, login');
    }
}
