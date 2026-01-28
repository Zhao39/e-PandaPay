<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class AccountSettings extends Component
{
    use LivewireAlert;

    public User $user;
    public $name;
    public $phone_number;
    public $enable_2fa;
    public $current_password;
    public $password;
    public $password_confirmation;
    public function mount(): void
    {
        $this->user = User::find(auth()->user()->id);

        $this->name = $this->user->name;
        $this->phone_number = $this->user->phone_number;
        $this->enable_2fa = $this->user->enable_2fa;
    }
    public function render()
    {
        return view('livewire.admin.account-settings');
    }

    public function save(): void
    {
        $val = $this->validate([
            'name' => ['required', 'max:190'],
            'phone_number' => ['required', 'max:190'],
            'enable_2fa' => ['required'],
        ]);

        $this->user->update($val);

        $this->alert(message: __('Account settings updated successfully.'));
    }

    public function changePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $this->user->update(['password' => Hash::make($this->password)]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->alert(type: 'success', message: 'Password reset is Successful.');
    }
}
