<form wire:submit='changePassword'>
    <div class="form-group">
        <label>Current Password</label>
        <x-form.input type="password" name="current_password" wire:model='current_password' required />
    </div>
    <div class="form-group">
        <label>New Password</label>
        <x-form.input type="password" name="password" wire:model='password' required />
    </div>
    <div class="form-group">
        <label>Confirm new password</label>
        <x-form.input type="password" name="password_confirmation" wire:model='password_confirmation' required />
    </div>
    <div class="text-right form-group">
        <x-ui.button>
            <x-spinner wire:loading />
            Change password
        </x-ui.button>
    </div>
</form>
