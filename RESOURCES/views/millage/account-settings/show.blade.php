@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Account Settings" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Account Settings</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data="{
        tab: @entangle('active_tab'),
    }">
        <div class="mb-3 col-lg-3 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    @can('update their profile')
                        <div class="card-profile">
                            <div>
                                @include('millage.account-settings.picture')
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
        <div class="col-lg-9">
            <div x-show="tab === 'profile'" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('millage.account-settings.profile')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'withdrawal'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('millage.account-settings.withrdwal-method')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'password'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('millage.account-settings.password')
                    </div>
                </div>
            </div>
            <div x-show="tab === 'privacy'" style="display: none" x-transition>
                <div class="card">
                    <div class="card-body">
                        @include('millage.account-settings.privacy')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
