<x-slot:title>
    Email Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Email Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Email Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row" x-data="{ driver: @entangle('mail_server') }">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <x-ui.button class="btn-sm" wire:click='testEmail'
                            wire:confirm="This email will be sent to your notifiable email.">
                            <x-spinner wire:loading='testEmail' wire:target='testEmail' />
                            Test Email
                        </x-ui.button>
                    </div>
                    <form action="" wire:submit="save('server')">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <x-preference label="Email Driver">
                                    <x-slot:check1>
                                        <x-radio name='mail_server' wire:model='mail_server' value="sendmail"
                                            label="Sendmail" @click="driver = 'sendmail'" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio name='mail_server' wire:model='mail_server' value="smtp"
                                            label="SMTP" @click="driver = 'smtp'" />
                                    </x-slot:check2>
                                </x-preference>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email From</label>
                                <x-form.input type="email" name="emailfrom" wire:model="emailfrom" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email From Name</label>
                                <x-form.input name="emailfromname" wire:model="emailfromname" required />
                            </div>
                            <div x-show="driver == 'smtp'" class="form-group col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>SMTP Host</label>
                                        <x-form.input name="smtp_host" wire:model="smtp_host"
                                            x-bind:required="driver == 'smtp'" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>SMTP Port</label>
                                        <x-form.input type="number" name="smtp_port" wire:model="smtp_port"
                                            x-bind:required="driver == 'smtp'" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>SMTP Encryption</label>
                                        <x-form.input name="smtp_encrypt" wire:model="smtp_encrypt"
                                            x-bind:required="driver == 'smtp'" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>SMTP Username</label>
                                        <x-form.input name="smtp_user" wire:model="smtp_user"
                                            x-bind:required="driver == 'smtp'" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>SMTP Password</label>
                                        <x-form.input name="smtp_password" wire:model="smtp_password"
                                            x-bind:required="driver == 'smtp'" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save('server')"></i>
                                    <x-spinner wire:loading wire:target="save('server')" />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div>
                        <h2 class="text-primary">Email Preferences</h2>
                        <h5 class="font-weight-bold">1) Admin Email Preference</h5>
                        <form action="" wire:submit="save('pref')">
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Deposit Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_deposit_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_deposit_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        deposits
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Withrdawal Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_withdrawal_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_withdrawal_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        place withdrawal requests
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Email on Plan Purchase">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_buyplan_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_buyplan_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        buy an investment plan.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive KYC Application Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_kyc_submission_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_kyc_submission_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        apply for KYC.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Expired Plan Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_expired_plan_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_expired_plan_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        investment plan expires.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Signal Subscription Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_signal_subscribe_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_signal_subscribe_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        subscribe to signal provider.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Membership Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_buy_course_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_buy_course_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        buy a membership course.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive CopyTrade Subscription Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_trade_account_submission_email'
                                                value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_trade_account_submission_email'
                                                value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when users
                                        subscribe to copytrade.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Receive Payment Method Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='receive_payment_method_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='receive_payment_method_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to receive an email notification when a new payment method
                                        is added to your app and if any payment method was edited.
                                    </small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 form-group">
                                    <h5 class="font-weight-bold">2) User Email Preference</h5>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Deposit Process Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_deposit_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_deposit_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when you process their
                                        deposit
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Withdrawal Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_withdrawal_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_withdrawal_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when you accept or
                                        cancel their withdrawal request.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Buy Plan Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_buyplan_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_buyplan_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when they purchase a new
                                        investment plan.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Expired Plan Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_expired_plan_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_expired_plan_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when their investment plan
                                        expires.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send ROI Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_roi_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_roi_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when they receive an ROI
                                        for
                                        their investment plan.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Copytrade Connection Success Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_trade_request_success_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_trade_request_success_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when their submited trading
                                        account has been connected successfully.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Trade Signal Subscription Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_signal_subscribe_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_signal_subscribe_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when they subscribe to your
                                        trade signal
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Membership Course Purchase Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_buy_course_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_buy_course_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when they purchase a
                                        membership course.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send KYC Submission Status Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_kyc_status_email' value="1"
                                                label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_kyc_status_email' value="0"
                                                label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if user will receive an email notification when you process their KYC
                                        Application.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Send Welcome Email">
                                        <x-slot:check1>
                                            <x-radio wire:model='send_welcome_email' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='send_welcome_email' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Indicates if you want to send welcome email to users after the verify their
                                        email address.
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="save('pref')"></i>
                                        <x-spinner wire:loading wire:target="save('pref')" />
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
</div>
