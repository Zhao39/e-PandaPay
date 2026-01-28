<form action="" wire:submit='saveProfile'>
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-lg-3">
                <label class="col-form-label">Username</label>
            </div>
            <div class="col-lg">
                <input type="text" class="form-control" id="fullName" wire:model='username' readonly>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-lg-3">
                <label for="fullName" class="col-form-label">Full Name</label>
            </div>
            <div class="col-lg">
                <x-form.input name="name" wire:model='name' required />
            </div>
        </div> <!-- / .row -->

        <div class="mb-4 row">
            <div class="col-lg-3">
                <label for="phone" class="col-form-label">Phone</label>
            </div>
            <div class="col-lg">
                <x-form.input type="tel" name="phone_number" wire:model='phone_number' />
            </div>
        </div> <!-- / .row -->

        <div class="mb-4 row">
            <div class="col-lg-3">
                <label for="emailAddress" class="col-form-label">Email address</label>
            </div>
            <div class="col-lg">
                <x-form.input type="email" name="email" wire:model='email' readOnly="true" />
            </div>
        </div> <!-- / .row -->

        <div class="mb-4 row">
            <div class="col-lg-3">
                <label for="country" class="col-form-label">Country</label>
            </div>
            <div class="col-lg">
                <x-form.input name="country" wire:model='country' readOnly="true" />
            </div>
        </div> <!-- / .row -->

        <div class="mb-4 row">
            <div class="col-lg-3">
                <label class="col-form-label">Address</label>
            </div>
            <div class="col-lg">
                <x-form.input name="address" wire:model='address' readOnly="true" />
            </div>
        </div> <!-- / .row -->

        <div class="mt-5 d-flex justify-content-end">
            <x-ui.button>
                <i class="bi bi-floppy" wire:loading.remove wire:target="saveProfile"></i>
                <x-spinner wire:loading wire:target="saveProfile" />
                Save changes
            </x-ui.button>
        </div>
    </div>
</form>
