<form action="" wire:submit='changePassword'>
    <div class="card-body">
        <div class="mb-4 row">
            <div class="col-lg-3">
                <label for="currentPassword" class="col-form-label">Current password</label>
            </div>
            <div class="col-lg">
                <x-form.input type="password" name="current_password" wire:model='current_password' required />
            </div>
        </div> <!-- / .row -->

        <div class="mb-4 row">
            <div class="col-lg-3">
                <label for="newPassword" class="col-form-label">New password</label>
            </div>

            <div class="col-lg">
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" id="newPassword" autocomplete="off"
                        data-toggle-password-input placeholder="Your new password" wire:model='password' required>
                    <button type="button" class="px-4 input-group-text text-secondary link-primary"
                        data-toggle-password></button>
                </div>
                @error('password')
                    <small class="text-danger fs-5">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg">
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" id="newPasswordAgain" autocomplete="off"
                        data-toggle-password-input placeholder="Confirm your new password"
                        wire:model='password_confirmation' required>
                    <button type="button" class="px-4 input-group-text text-secondary link-primary"
                        data-toggle-password></button>
                </div>
                <div class="invalid-feedback">Please confirm your new password again</div>
            </div>
        </div> <!-- / .row -->

        <div class="row">
            <div class="col-lg offset-lg-3">
                <div class="alert alert-light mw-450px" role="alert">
                    <h4 class="mb-3">Password requirements:</h4>
                    <ul class="p-3 mb-0">
                        <li>Minimum 8 characters long - the more, the better</li>
                        <li>At least one lowercase character</li>
                        <li>At least one uppercase character</li>
                        <li>At least one number, symbol.</li>
                    </ul>
                </div>
            </div>
        </div> <!-- / .row -->

        <div class="mt-5 d-flex justify-content-end">
            <!-- Button -->
            <button type="submit" class="btn btn-primary">
                <x-spinner wire:loading />
                Save changes
            </button>
        </div>
    </div>
</form>
