@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="page-title">
        <div class="mb-3 row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Account Settings</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data="{
        tab: @entangle('active_tab'),
    }">
        <div class="mb-3 col-lg-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    @can('update their profile')
                        <div class="card-profile">
                            <div>
                                @include('purpose.account-settings.picture')
                            </div>
                        </div>
                    @endcan
                    <ul class="nav flex-lg-column">
                        @can('update their profile')
                            <li class="nav-item active">
                                <a class="nav-link" href="#"
                                    x-bind:class="tab === 'profile' ? 'bg-light active' : ''"
                                    @click.prevent="tab = 'profile'">
                                    <i class="bi bi-person-gear"></i>
                                    Profile Information
                                </a>
                            </li>
                        @endcan
                        @can('update their withdrawal payment options')
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    x-bind:class="tab === 'withdrawal' ? 'bg-light active' : ''"
                                    @click.prevent="tab = 'withdrawal'">
                                    <i class="bi bi-wallet"></i>
                                    Withdrawal Method
                                </a>
                            </li>
                        @endcan
                        @can('change their password')
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    x-bind:class="tab === 'password' ? 'bg-light active' : ''"
                                    @click.prevent="tab = 'password'"> <i class="bi bi-lock"></i> Password</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href=""
                                x-bind:class="tab === 'privacy' ? 'bg-light active' : ''"
                                @click.prevent="tab = 'privacy'"> <i class="bi bi-shield"></i> Privacy & Safety</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div x-show="tab === 'profile'" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('purpose.account-settings.profile')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'withdrawal'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('purpose.account-settings.withrdwal-method')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'password'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('purpose.account-settings.password')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'privacy'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('purpose.account-settings.privacy')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
