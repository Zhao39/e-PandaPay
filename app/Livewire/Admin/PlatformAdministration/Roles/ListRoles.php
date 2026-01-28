<?php

namespace App\Livewire\Admin\PlatformAdministration\Roles;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class ListRoles extends Component
{
    use LivewireAlert;

    public $addNewRole = false;
    public $updateMode = false;
    public $role;
    public Role $rolle;
    public $permissions = [];

    public function render()
    {
        return view('livewire.admin.platform-administration.roles.list-roles', [
            'roles' => Role::latest()->get(),
        ]);
    }

    public function save(): void
    {
        Gate::authorize('update roles & permissions');
        $this->validate([
            'role' => ['required', 'string', 'unique:roles,name'],
        ]);

        $role = Role::create(['name' => $this->role]);
        $role->givePermissionTo($this->permissions);
        activity()->log("{$this->role} role created");
        $this->alert(type: 'success', message: "{$this->role} role added Successfully.");
        $this->reset();
    }

    public function setRole(string $role): void
    {
        Gate::authorize('update roles & permissions');
        $role = Role::firstWhere('name', $role);
        if (! $role) {
            abort(403);
        }
        $this->permissions = $role->permissions->pluck('name');
        $this->rolle = $role;
        $this->role = $role->name;
        $this->updateMode = true;
    }

    public function update(): void
    {
        Gate::authorize('update roles & permissions');
        $this->rolle->name = $this->role;
        $this->rolle->save();
        $this->rolle->syncPermissions($this->permissions);
        activity()->log("{$this->role} role updated");
        $this->alert(type: 'success', message: "{$this->role} role updated Successfully.");
        //$this->reset();
    }

    public function deleteRole(string $role): void
    {
        Gate::authorize('update roles & permissions');
        $role = Role::firstWhere('name', $role);
        if (! $role) {
            abort(403);
        }
        activity()->log("{$role->name} role deleted");
        $role->delete();
        $this->alert(type: 'success', message: 'Role deleted Successfully.');
    }

    public function resetProps()
    {
        $this->reset();
    }
}
