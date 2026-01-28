@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 col-sm-12">
                            <div class="mb-3">
                                <div class="text-center">
                                    <h2>Begin your ID-Verification</h2>
                                    <small class="d-block">
                                        Please type carefully and fill out the form with your personal
                                        details.
                                    </small>
                                    <small>
                                        Your can’t edit these details once you submit this form.
                                    </small>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">Personal Details</h5>
                                <p>Your simple personal information required for identification</p>
                            </div>
                            <form action="{{ route('user.kyc.submit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label for="firstname">First name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <x-form.input name="first_name" wire:model='first_name' required />
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="lastname">Last name <span class="text-danger">*</span></label>
                                        <x-form.input name="last_name" wire:model='last_name' required />
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <x-form.input type="email" name="email" wire:model='email' required />
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="phone_number">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <x-form.input name="phone_number" wire:model='phone_number' required />
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="dob">Date of birth <span class="text-danger">*</span></label>
                                        <x-form.input type="date" name="dob" wire:model='dob' required />
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="social_media">Twitter or Facebook username</label>
                                        <x-form.input name="social_media" wire:model='social_media' />
                                    </div>
                                    <div class="pt-3 mt-3 col-12 border-top">
                                        <h5 class="mb-0 font-weight-bold">Your Address</h5>
                                        <p>Your simple location information required for identification</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="mb-2 col-md-6">
                                                <label for="address">Address line
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <x-form.input name="address" wire:model='address' required />
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="city">City<span class="text-danger">*</span></label>
                                                <x-form.input name="city" wire:model='city' required />
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="state">State<span class="text-danger">*</span></label>
                                                <x-form.input name="state" wire:model='state' required />
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="country">Nationality
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <x-form.input name="country" wire:model='country' required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3 mt-3 col-12 border-top">
                                        <h5 class="mb-0 font-weight-bold">Document Upload</h5>
                                        <p>Your simple personal document required for identification</p>
                                    </div>
                                    <div class="col-12 d-lg-flex justify-content-between">
                                        <div class="mb-3 form-check">
                                            <input type="radio" name="document_type" wire:model="document_type"
                                                value="Int'l Passport" class="form-check-input">
                                            <label class="form-check-label" for="formRadio1"> Int'l Passport</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="radio" name="document_type" wire:model="document_type"
                                                value="National ID" class="form-check-input">
                                            <label class="form-check-label" for="formRadio1"> National ID</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="radio" name="document_type" wire:model="document_type"
                                                value="Drivers License" class="form-check-input">
                                            <label class="form-check-label" for="formRadio1">Drivers License</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mt-4">
                                            <h6 class=" font-weight-bold">To avoid delays when verifying
                                                account, Please make sure your document meets the criteria
                                                below:</h6>
                                            <ul class=" list-group">
                                                <li>
                                                    <i class="fas fa-check-square text-primary"></i>
                                                    Chosen credential must not have expired.
                                                </li>
                                                <li>
                                                    <i class="fas fa-check-square text-primary"></i>
                                                    Document should be in good condition and clearly visible.
                                                </li>
                                                <li>
                                                    <i class="fas fa-check-square text-primary"></i>
                                                    Make sure that there is no light glare on the document.
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-2">
                                            <label>Upload front side <span class="text-danger">*</span></label>
                                            <input type="file" name="frontImg" wire:model.live='frontImg'
                                                class="form-control" required>
                                            <small style="font-size: 9px">Size should not be greater than 30MB (images
                                                & PDF
                                                allowed)</small>
                                        </div>
                                        <div class="mt-3">
                                            <label>Upload back side <span class="text-danger">*</span></label>
                                            <input type="file" name="backImg" wire:model.live='backImg'
                                                class="form-control" required>
                                            <small style="font-size: 9px">Size should not be greater than 30MB (images
                                                & PDF
                                                allowed)</small>
                                        </div>
                                    </div>
                                    <div class="mt-4 col-12">
                                        <div class="mb-5 custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                required>
                                            <label class="custom-control-label" for="customCheck1">
                                                All The Information I Have Entered Is Correct.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <x-spinner wire:loading wire:target='submit' />
                                            Submit Application
                                        </button>
                                        <a href="{{ route('user.kyc.start') }}" class="px-4 btn btn-secondary btn-sm"
                                            @if ($settings->spa_mode) wire:navigate @endif>Cancel
                                            Application</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
