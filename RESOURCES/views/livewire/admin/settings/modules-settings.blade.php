<x-slot:title>
    System Modules
</x-slot:title>
<div>
    <x-breadcrumbs title="Modules">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Modules</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div wire:loading wire:target='updateModule'>
                        <progress max="100"></progress>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <x-preference label="Investment">
                                <x-slot:check1>
                                    <x-radio wire:model='modules.investment'
                                        wire:click="updateModule('investment','true')" value="true" label="Enable" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='modules.investment'
                                        wire:click="updateModule('investment','false')" value="false"
                                        label="Disable" />
                                </x-slot:check2>
                            </x-preference>
                            <small class="d-block">
                                If enabled, the system will display all functionalities relating to investment on user
                                dashboard.
                            </small>
                        </div>
                        <div class="form-group col-lg-6">
                            <x-preference label="MAM - Copytrading">
                                <x-slot:check1>
                                    <x-radio wire:model='modules.subscription'
                                        wire:click="updateModule('subscription','true')" value="true"
                                        label="Enable" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='modules.subscription'
                                        wire:click="updateModule('subscription','false')" value="false"
                                        label="Disable" />
                                </x-slot:check2>
                            </x-preference>
                            <small class="d-block">
                                If enabled, the system will display all functionalities relating to metatrader
                                accounts management and subscription on user dashboard.
                            </small>
                        </div>
                        <div class="form-group col-lg-6">
                            <x-preference label="Crypto Swap">
                                <x-slot:check1>
                                    <x-radio wire:model='modules.cryptoswap'
                                        wire:click="updateModule('cryptoswap','true')" value="true" label="Enable" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='modules.cryptoswap'
                                        wire:click="updateModule('cryptoswap','false')" value="false"
                                        label="Disable" />
                                </x-slot:check2>
                            </x-preference>
                            <small class="d-block">
                                If enabled, the system will display all functionalities about crypto swapping on
                                user dashboard.
                            </small>
                        </div>
                        <div class="form-group col-lg-6">
                            <x-preference label="Education(LMS)-membership">
                                <x-slot:check1>
                                    <x-radio wire:model='modules.membership'
                                        wire:click="updateModule('membership','true')" value="true" label="Enable" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='modules.membership'
                                        wire:click="updateModule('membership','false')" value="false"
                                        label="Disable" />
                                </x-slot:check2>
                            </x-preference>
                            <small class="d-block">
                                If enabled, the system will display all functionalities about Membership/education
                                on user dashboard.
                            </small>
                        </div>
                        <div class="form-group col-lg-6">
                            <x-preference label="Signal Provider">
                                <x-slot:check1>
                                    <x-radio wire:model='modules.signal' wire:click="updateModule('signal','true')"
                                        value="true" label="Enable" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='modules.signal' wire:click="updateModule('signal','false')"
                                        value="false" label="Disable" />
                                </x-slot:check2>
                            </x-preference>

                            <small class="d-block">
                                If enabled, the system will display all functionalities about signal providing on
                                user dashboard.
                            </small>
                        </div>
                    </div>
                    <hr>
                    <form wire:submit='savePermissions' class="mt-3">
                        <div class="form-row">
                            <div class="mt-3 form-group col-12">
                                <h5 class="m-0 font-weight-bold"> Enable/Disable Modules on User Dashboard </h5>
                                <p class="m-0">Specifies if user can: </p>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="form-check">
                                    <x-form.permission-check label="make deposit" />
                                    <x-form.permission-check label="make withdrawal" />
                                    <x-form.permission-check label="see profit history" />
                                    <x-form.permission-check label="purchase plan" />
                                    <x-form.permission-check label="see their plans" />
                                    <x-form.permission-check label="refer users" />
                                    <x-form.permission-check label="contact support" />
                                    <x-form.permission-check label="see their transactions history" />
                                    {{-- <x-form.permission-check label="update email preference" /> --}}
                                    <x-form.permission-check label="see trade chart on dashboard" />
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="form-check">
                                    <x-form.permission-check label="update their withdrawal payment options" />
                                    <x-form.permission-check label="change their password" />
                                    <x-form.permission-check label="use two-factor authentication" />
                                    <x-form.permission-check label="manage browser sessions" />
                                    <x-form.permission-check label="update their profile" />
                                    <x-form.permission-check label="delete their account" />
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="savePermissions"></i>
                                    <x-spinner wire:loading wire:target="savePermissions" />
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
