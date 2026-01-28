<form wire:submit='saveProfile'>
    <div class="row">
        <div class="col-lg-6 form-group">
            <label>Username</label>
            <x-form.input name="username" wire:model='username' readonly />
        </div>
        <div class="col-lg-6 form-group">
            <label>Fullname</label>
            <x-form.input name="name" wire:model='name' />
        </div>
        <div class="col-lg-6 form-group">
            <label>Phone Number</label>
            <x-form.input type="tel" name="phone_number" wire:model='phone_number' />
        </div>
        <div class="col-lg-6 form-group">
            <label>Email Address</label>
            <x-form.input type="email" name="email" wire:model='email' readOnly="true" />
        </div>
        <div class="col-lg-6 form-group">
            <label>Country</label>
            <x-form.input name="country" wire:model='country' readOnly="true" />
        </div>
        <div class="col-lg-6 form-group">
            <label>Address</label>
            <x-form.input name="address" wire:model='address' readOnly="true" />
        </div>
        <div class="text-right col-12 form-group">
            <x-ui.button>
                <i class="bi bi-floppy" wire:loading.remove wire:target="saveProfile"></i>
                <x-spinner wire:loading wire:target="saveProfile" />
                Save
            </x-ui.button>
        </div>
    </div>
</form>
