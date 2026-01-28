@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    View {{ $user->name }}
</x-slot:title>
<div>
    <x-breadcrumbs title="Manage User">
        <li class="nav-item">
            <a href="{{ route('admin.users.listUsers') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Users List
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ $user->name }}</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="order-2 col-md-8 order-lg-1" x-data="{ tab: 'overview' }">
            <div class="card card-with-nav">
                <div class="card-header">
                    <div class="row row-nav-line">
                        @include('livewire.admin.manage-users.includes.nav')
                    </div>
                </div>
            </div>
            <div class="row" x-show="tab === 'overview'" x-transition>
                @include('livewire.admin.manage-users.includes.overview')
            </div>
            <div class="row" style="display: none" x-show="tab === 'settings'" x-transition>
                @include('livewire.admin.manage-users.profile-settings')
            </div>
            <div class="row" style="display: none" x-show="tab === 'security'" x-transition>
                @include('livewire.admin.manage-users.security')
            </div>
            <div class="row" style="display: none" x-show="tab === 'session'" x-transition>
                @include('livewire.admin.manage-users.sessions')
            </div>
            <div class="row" style="display: none" x-show="tab === 'refferals'" x-transition>
                @include('livewire.admin.manage-users.referrals')
            </div>
            <div class="row" style="display: none" x-show="tab === 'account'" x-transition>
                @include('livewire.admin.manage-users.account')
            </div>
        </div>
        <div class="order-1 col-md-4 order-lg-2">
            <div class="card card-profile">
                <div>
                    <livewire:admin.manage-users.profile-picture :user="$user" />
                </div>
                <div class="card-footer">
                    <div class="text-center row user-stats">
                        <div class="col-6">
                            <div class="number">
                                <span @class([
                                    'badge',
                                    'badge-success' => $user->status->value == 'active',
                                    'badge-danger' => $user->status->value == 'blocked',
                                ])>{{ ucfirst($user->status->value) }}</span>
                            </div>
                            <div class="title">Status</div>
                        </div>
                        <div class="col-6">
                            <div class="number">
                                <span
                                    @class([
                                        'badge',
                                        'badge-success' => $user->account_verify == 'verified',
                                        'badge-danger' => $user->account_verify != 'verified',
                                    ])>{{ ucfirst($user->account_verify ?? 'Not Verified') }}</span>
                            </div>
                            <div class="title">KYC</div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="number">
                                        <span
                                            @class([
                                                'badge',
                                                'badge-success' => $user->trade_mode,
                                                'badge-danger' => !$user->trade_mode,
                                            ])>{{ ucfirst($user->trade_mode ? 'on' : 'off') }}</span>
                                    </div>
                                    <div class="title">Auto Trade</div>
                                </div>
                                <div class="col-6">
                                    <div class="number">
                                        <span
                                            @class([
                                                'badge',
                                                'badge-success' => !is_null($user->email_verified_at),
                                                'badge-danger' => is_null($user->email_verified_at),
                                            ])>{{ $user->email_verified_at ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="title">Verfied Email</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
