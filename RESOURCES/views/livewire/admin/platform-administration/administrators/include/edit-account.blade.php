<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form wire:submit='updateMemberInfo'>
                    <div class="form-row">
                        <div class="mb-3 col-lg-6">
                            <label>Fullname</label>
                            <x-form.input wire:model='name' name="name" required />
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>Email Address</label>
                            <x-form.input type="email" name="email" wire:model='email' required />
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>Phone Number</label>
                            <x-form.input type="tel" wire:model='phone_number' name="phone_number" required />
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>Roles</label>
                            <x-form.select name="roles" wire:model='roles' :options="$this->rolesList" column="name" multiple
                                required />
                            <small>
                                You can select multiple roles. Member with Super Admin role have all
                                permissions by default.
                            </small>
                        </div>
                        <div class="col-lg-12">
                            <x-ui.button>
                                <x-spinner wire:loading wire:target="updateMemberInfo" />
                                Update
                            </x-ui.button>
                            <x-ui.button type="button" class="btn-danger" wire:click='resetProps'>
                                <x-spinner wire:loading wire:target="resetProps" />
                                Cancel
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
