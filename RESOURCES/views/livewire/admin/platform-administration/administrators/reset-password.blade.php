<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form wire:submit='resetAdminPassword'>
                    <div class="form-row">
                        <div class="mb-3 col-lg-6">
                            <label>Enter New Password</label>
                            <x-form.input type="password" name="password" wire:model='password' required />
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>Confirm New Password</label>
                            <x-form.input type="password" name="password_confirmation"
                                wire:model='password_confirmation' required />
                        </div>
                        <div class="col-lg-12">
                            <x-ui.button>
                                Submit
                            </x-ui.button>
                            <x-ui.button type="button" class="btn-danger" wire:click='resetProps'>
                                Cancel
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
