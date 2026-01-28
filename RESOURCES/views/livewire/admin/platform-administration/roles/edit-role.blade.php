<form action="" method="post" wire:submit='update'>
    <div class="mb-3">
        <label for="">Role Name</label>
        <x-form.input name="role" wire:model='role' placeholder="eg. Super Admin" :readOnly="$role == 'User'" />
        <small class="font-weight-bold">
            NOTE: Super Admin have access to all permissions, do not check any
            permissions when updating a "Super Admin" role.
        </small>
    </div>
    @include('livewire.admin.platform-administration.roles.permissions')
    <div class="mb-3">
        <x-ui.button>
            <i class="bi bi-floppy" wire:loading.remove wire:target="update"></i>
            <x-spinner wire:loading wire:target="update" />
            Update
        </x-ui.button>
        <x-ui.button type="button" class="btn-info" @click="updateRole = false; $wire.resetProps()">
            Cancel
        </x-ui.button>
    </div>
</form>
