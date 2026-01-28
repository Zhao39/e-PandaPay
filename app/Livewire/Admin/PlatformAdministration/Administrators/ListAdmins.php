<?php

namespace App\Livewire\Admin\PlatformAdministration\Administrators;

use App\Enums\UserStatus;
use App\Models\User;
use App\Rules\PhoneNumberRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class ListAdmins extends Component
{
    use LivewireAlert;

    public $addNewMember = false;
    public $updateMember = false;
    public $resetPassword = false;
    public $name;
    public $email;
    public $phone_number;
    public $password;
    public $password_confirmation;
    public $is_admin = true;
    public $roles = [];
    public User $admin;

    #[Computed()]
    public function admins(): Collection
    {
        return User::isAdmin()->with('roles')->latest()->get();
    }

    #[Computed()]
    public function rolesList(): Collection
    {
        return Role::latest()->where('name', '!=', 'User')->get();
    }

    public function render()
    {
        return view('livewire.admin.platform-administration.administrators.list-admins');
    }

    public function addMember(): void
    {
        // authroize action
        Gate::authorize('create admin');

        // validate inputs
        $this->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['nullable', new PhoneNumberRule(), 'min:5'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        // add member to database
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin,
        ]);
        // assign roles select to this new member
        $user->assignRole($this->roles);
        // show alert
        $this->alert(type: 'success', message: 'New Member Added Successfully.');
        //reset properties;
        activity()->log("New Admin {$this->name} added");
        $this->resetProps();
    }

    public function resetProps(): void
    {
        $this->reset();
    }

    public function setForUpdate(string $id): void
    {
        // authroize action
        Gate::authorize('edit admin details');
        $admin = User::with('roles')->find($id);
        $this->admin = $admin;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone_number = $admin->phone_number;
        $this->roles = $admin->roles()->pluck('name');
        $this->updateMember = true;
    }

    public function updateMemberInfo(): void
    {
        Gate::authorize('edit admin details');

        $validated = $this->validate([
            'name' => ['required', 'string',  Rule::unique('users')->ignore($this->admin->id)],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', new PhoneNumberRule(), 'min:5'],
        ]);

        $this->admin->update($validated);

        $this->admin->syncRoles($this->roles);

        $this->alert(type: 'success', message: 'Details updated Successfully.');
        //reset properties;

        activity()->log("Admin {$this->admin->name} updated");
        $this->resetProps();
    }

    public function setStatus(string $id, string $status): void
    {
        Gate::authorize('block and unblock admin');
        $admin = User::select('id', 'status')->find($id);
        $admin->status = $status === 'active' ? UserStatus::Active : UserStatus::Blocked;
        $admin->save();
        activity()->log("Admin {$admin->name} {$status}");
        $this->alert(type: 'success', message: 'Action Successful.');
    }

    public function setReset(string $id): void
    {
        // authroize action
        Gate::authorize('change admin password');
        $this->admin = User::find($id);
        $this->resetPassword = true;
    }

    public function setDelete(string $id): void
    {
        // authroize action
        Gate::authorize('delete admin');
        $this->admin = User::find($id);
    }

    public function resetAdminPassword(): void
    {
        // authroize action
        Gate::authorize('change admin password');
        $this->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $this->admin->update(['password' => Hash::make($this->password)]);
        activity()->log("Admin {$this->admin->name} password reset");
        $this->alert(type: 'success', message: 'Password reset is Successful.');
        $this->resetProps();
    }

    public function deleteAccount(): void
    {
        Gate::authorize('change admin password');
        $this->admin->delete();
        $this->alert(type: 'success', message: 'Admin Account Deleted Successfully.');
    }
}
