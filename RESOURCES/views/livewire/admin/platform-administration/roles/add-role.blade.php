<div class="card">
    <div class="card-body">
        <form action="" method="post" wire:submit='save'>
            <div class="mb-3">
                <label for="">Role Name</label>
                <x-form.input name="role" wire:model='role' placeholder="eg. Super Admin" />
                <small class="font-weight-bold">
                    NOTE: Super Admin have access to all permissions, do not check any
                    permissions when adding a "Super Admin" role.
                </small>
            </div>
            @include('livewire.admin.platform-administration.roles.permissions')
            <div>
                <x-ui.button>
                    <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                    <x-spinner wire:loading wire:target="save" />
                    Save
                </x-ui.button>
                <x-ui.button type="button" class="btn-info" @click="addNewRole = false; $wire.resetProps()">
                    Cancel
                </x-ui.button>
            </div>
        </form>

    </div>
</div>
