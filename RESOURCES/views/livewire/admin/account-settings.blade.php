<x-slot:title>
    Account Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Account Settings">
        <li class="nav-item">
            <a href="#">Account Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-md-12" x-data="{ tab: 'settings' }">
            <div class="card card-with-nav">
                <div class="card-header">
                    <div class="row row-nav-line">
                        <ul class="pl-3 nav nav-tabs nav-line nav-color-secondary w-100" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" :class="{ 'active': tab === 'settings' }"
                                    x-on:click.prevent="tab = 'settings'" href="">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" :class="{ 'active': tab === 'password' }"
                                    x-on:click.prevent="tab = 'password'" href="">Change Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" x-show="tab === 'settings'" x-transition>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <form wire:submit='save'>
                                        <div class="form-group">
                                            <label>Fullname</label>
                                            <x-form.input name="name" wire:model='name' required />
                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <x-form.input type="tel" name="name" wire:model='phone_number'
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label>Two Factor Authentication</label>
                                            <x-preference label="">
                                                <x-slot:check1>
                                                    <x-radio name='enable_2fa' wire:model='enable_2fa' value="1"
                                                        label="Enable" />
                                                </x-slot:check1>
                                                <x-slot:check2>
                                                    <x-radio name='enable_2fa' wire:model='enable_2fa' value="0"
                                                        label="Disable" />
                                                </x-slot:check2>
                                            </x-preference>
                                        </div>
                                        <div class="form-group">
                                            <x-ui.button>
                                                <i class="bi bi-floppy" wire:loading.remove></i>
                                                <x-spinner wire:loading />
                                                Save
                                            </x-ui.button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-5">
                                    <livewire:admin.manage-users.profile-picture :user="$user" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: none" class="row" x-show="tab === 'password'" x-transition>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <form wire:submit='changePassword'>
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <x-form.input type="password" name="current_password"
                                                wire:model='current_password' required />
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <x-form.input type="password" name="password" wire:model='password'
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm new password</label>
                                            <x-form.input type="password" name="password_confirmation"
                                                wire:model='password_confirmation' required />
                                        </div>
                                        <div class="form-group">
                                            <x-ui.button>
                                                <x-spinner wire:loading />
                                                Change password
                                            </x-ui.button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
