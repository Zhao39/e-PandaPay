<x-slot:title>
    Site Preference
</x-slot:title>

<div>
    <x-breadcrumbs title="Site Preference">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Site Preference</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save('pre')">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Contact Email</label>
                                <x-form.input type="email" name="contact_email" wire:model="contact_email" required />
                                <small>
                                    This email will be displayed for your users to be able to contact you if they
                                    encounter any
                                    issues or to make inquiries.
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Notification Email</label>
                                <x-form.input type="email" name="notifiable_email" wire:model="notifiable_email"
                                    required />
                                <small>
                                    This is where all of the email notification you received about your system will go
                                    to. It
                                    can be your personal
                                    email address and will not be displayed anywhere on your system.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <div wire:ignore>
                                    <label>Website Currency</label>
                                    <select class="select2 form-control" style="width: 100%">
                                        @foreach ($currencies as $key => $currency)
                                            <option>
                                                {{ $key }} - {{ html_entity_decode($currency) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="font-weight-bold text-muted">
                                    Current Currency: {{ $currency_current }} ({{ $s_currency }})
                                </small>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Referral bonus should come from</label>
                                <select wire:model="referral_proffit_from" class="form-control">
                                    <option value="Deposit">Deposit</option>
                                    <option value="Profit">Profit(ROI)</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>SPA Mode</label>
                                <x-preference label="">
                                    <x-slot:check1>
                                        <x-radio wire:model='spa_mode' value="1" label="Enable" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='spa_mode' value="0" label="Disable" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    SPA Mode makes your entire website behave like a single page
                                    application and removes page load as you navigate your site which makes it 2x
                                    faster.
                                    <strong>Note Some pages on the admin might still do a full page load
                                        because of some
                                        javascript dependencies. </strong>
                                </small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Progress Bar Colour in SPA Mode</label>
                                <input type="color" wire:model='progress_bar_color' class="w-100">
                            </div>
                            <div class="form-group col-md-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save('pre')"></i>
                                    <x-spinner wire:loading wire:target="save('pre')" />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="" class="mt-4" wire:submit="save('mai')">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <x-preference label="Annoucment">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_annoucement' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_annoucement' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Trade Mode">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_trade_mode' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_trade_mode' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Users will not receive thier ROI automatically if this is OFF
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Weekend Trade">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_weekend_trade' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_weekend_trade' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Users will not receive ROI automatically on weekends if this is OFF.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="OTP on Withdrawals">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_withdrawal_otp' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_withdrawal_otp' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If turned On, Users will be required to enter an OTP when making a withdrawal
                                    request, OTP will be sent to their email address.
                                </small>
                            </div>

                            <div class="form-group col-lg-6">
                                <x-preference label="Google Translation">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_google_translate' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_google_translate' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If turned on, users will have the option of selecting their preferred language
                                    through google translation
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="KYC(Verification)">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_kyc' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_kyc' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If turned on, users will need to submit required documents to get verified before
                                    they can place a withdrawal request.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="KYC(Verification) on Registraion">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_kyc_registration' value="1"
                                            label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_kyc_registration' value="0"
                                            label="Off" />
                                    </x-slot:check2>
                                </x-preference>

                                <small class="d-block">if turned on, Users will have to go through the verification
                                    process upon
                                    registration and they will not be allowed to carry out any operation on your system
                                    until
                                    they have been verified by the admin. Note this will affect existing users who have
                                    not
                                    completed their KYC. <strong>After they have submitted an application, you will also
                                        need to
                                        verify the user from your end before they can procced.</strong>
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Google Login">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_social_login' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_social_login' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Google Login allows users to login/register with their google account
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Email Verification">
                                    <x-slot:check1>
                                        <x-radio wire:model='enable_email_verification' value="1"
                                            label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='enable_email_verification' value="0"
                                            label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If email verification is disabled users will not be ask to verify their email
                                    address after registration.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Return Investment Capital">
                                    <x-slot:check1>
                                        <x-radio wire:model='return_capital' value="1" label="Yes" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='return_capital' value="0" label="No" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If return capital is No, the system will not credit the user with his capital after
                                    investment plan expires.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Plan Cancellation">
                                    <x-slot:check1>
                                        <x-radio wire:model='should_cancel_plan' value="1" label="On" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='should_cancel_plan' value="0" label="Off" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Turn it on if you want users to be able to cancel their active investment plans.
                                    Note the capital will be returned to users account when they cancel their plan and
                                    any profit already incurred will remain.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Use E-PandaPay Copytrading">
                                    <x-slot:check1>
                                        <x-radio wire:model='use_copytrade' value="1" label="Yes" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='use_copytrade' value="0" label="No" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Turn off if you have your own copy trade system, and you only want to process users
                                    subscription without using our copytrade system.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Use Terms & Condition">
                                    <x-slot:check1>
                                        <x-radio wire:model='use_terms' value="1" label="Yes" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='use_terms' value="0" label="No" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Turn off if you do not want users to see and accept terms and conditions
                                </small>
                            </div>
                            <div class="form-group col-md-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save('mai')"></i>
                                    <x-spinner wire:loading wire:target="save('mai')" />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        const selects = $('.select2');
        selects.select2({
            placeholder: "Select User",
            allowClear: true
        });
        selects.on('change', function() {
            $wire.currency = this.value;
        });
    </script>
@endscript
