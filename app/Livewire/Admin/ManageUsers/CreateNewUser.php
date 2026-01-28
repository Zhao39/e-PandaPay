<?php

namespace App\Livewire\Admin\ManageUsers;

use App\Models\User;
use App\Services\Country;
use App\Services\Website;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CreateNewUser extends Component
{
    use LivewireAlert;

    public $saveType = 'save';
    public $name;
    public $email;
    public $phone_number;
    public $password;
    public $username;
    public $password_confirmation;
    public $verifyEmail = 1;
    public $country = 'Afghanistan';
    public $countries;
    public $reffered_by;

    public function mount()
    {
        $this->countries = Country::all();
    }

    public function render()
    {
        return view('livewire.admin.manage-users.create-new-user');
    }

    public function saveUser(): void
    {
        // authroize action
        Gate::authorize('create user');

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'unique:users', 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'country' => ['required'],
            'reffered_by' => ['nullable', 'exists:users,username'],
        ]);

        $username = strtolower($this->username);
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $username,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'country' => $this->country,
            'email_verified_at' => now(),
            'refferal_link' => Website::url(true) . "/ref/{$username}",
        ];

        // set refferal
        if ($this->reffered_by) {
            $refferal = User::firstWhere('username', $this->reffered_by);
            $data = array_merge($data, ['reffered_by' => $refferal->id]);
        }
        // save user to database
        $user = User::create($data);

        // assign role User to this new user
        $user->assignRole('User');

        if ($this->saveType === 'save') {
            $this->alert(message: 'User account created successfully.');
            $this->reset(['name', 'username', 'email', 'phone_number', 'password', 'country', 'reffered_by', 'password_confirmation']);
        }

        if ($this->saveType === 'save & exit') {
            $this->flash(message: 'User account created successfully.', redirect: route('admin.users.listUsers'));
        }
    }

    public function updatedUsername(): void
    {
        $this->username = strtolower($this->username);
    }
}
