<!-- Sidenav -->
@use('\Illuminate\Support\Number', 'Number')
<div class="sidenav" id="sidenav-main">
    <!-- Sidenav header -->
    <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}"
            @if ($settings->spa_mode) wire:navigate @endif>
            <img src="{{ asset('storage/' . $settings->logo) }}" class="navbar-brand-img" alt=" {{ $settings->site_name }}"
                width="{{ $settings->user_dashboard_logo_size }}">
        </a>
        <div class="ml-auto">
            <!-- Sidenav toggler -->
            <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin"
                data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- User mini profile -->
    <div class="text-center sidenav-user d-flex flex-column align-items-center justify-content-between">
        <!-- Avatar -->
        <div>
            @if (auth()->user()->profile_photo_path)
                <div class="avatar rounded-circle avatar-xl">
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="..."
                        class="border avatar-img rounded-circle">
                </div>
            @else
                <a href="#" class="avatar rounded-circle avatar-xl">
                    <i class="fas fa-user-circle fa-4x"></i>
                </a>
            @endif
            <div class="mt-4">
                <h5 class="mb-0 text-white"> {{ Auth::user()->name }}</h5>
                <span class="mb-3 text-sm text-white d-block opacity-8">online</span>
                <a href="#" class="shadow btn btn-sm btn-white btn-icon rounded-pill hover-translate-y-n3">
                    <span class="btn-inner--icon"><i class="far fa-coins"></i></span>
                    <span class="btn-inner--text">
                        {{ Number::currency(Auth::user()->account_bal, $settings->s_currency) }}
                    </span>
                </a>
            </div>
        </div>
        <!-- User info -->
        <!-- Actions -->
        <div class="mt-4 w-100 actions d-flex justify-content-between">

        </div>
    </div>
    <!-- Application nav -->
    <div class="clearfix nav-application">
        <a href="{{ route('user.dashboard') }}" @class([
            'text-sm btn btn-square ',
            'active' => request()->routeIs('user.dashboard'),
        ])
            @if ($settings->spa_mode) wire:navigate @endif>
            <span class="btn-inner--icon d-block"><i class="far fa-home fa-2x"></i></span>
            <span class="pt-2 btn-inner--icon d-block">Home</span>
        </a>
        @can('make deposit')
            <a href="{{ route('user.deposit.make') }}" @class([
                'text-sm btn btn-square ',
                'active' => request()->routeIs('user.deposit.*'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block">
                    <i class="far fa-download fa-2x"></i>
                </span>
                <span class="pt-2 btn-inner--icon d-block">Deposit</span>
            </a>
        @endcan
        @can('make withdrawal')
            <a href="{{ route('user.withdraw.request') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.withdraw.request'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block">
                    <i class="fas fa-arrow-alt-circle-up fa-2x"></i>
                </span>
                <span class="pt-2 btn-inner--icon d-block">Withdraw</span>
            </a>
        @endcan
        @can('see their transactions history')
            <a href="{{ route('user.transactions.deposit') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.transactions.*'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block"><i class="fas fa-money-check-alt fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Transactions</span>
            </a>
        @endcan
        @if ($settings->use_transfer)
            <a href="{{ route('user.transferfund') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.transferfund'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block"><i class="fas fa-exchange fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Transfer funds</span>
            </a>
        @endif

        @if ($mod['investment'] == 'true')
            @can('purchase plan')
                <a href="{{ route('user.investment.buyplan') }}" @class([
                    'text-sm btn btn-square',
                    'active' => request()->routeIs('user.investment.buyplan'),
                ])
                    @if ($settings->spa_mode) wire:navigate @endif>
                    <span class="btn-inner--icon d-block"><i class="fas fa-hand-holding-seedling fa-2x"></i></span>
                    <span class="pt-2 btn-inner--icon d-block">Trading Plans</span>
                </a>
            @endcan
            @can('see their plans')
                <a href="{{ route('user.investment.myplans') }}" @class([
                    'text-sm btn btn-square ',
                    'active' =>
                        request()->routeIs('user.investment.myplans') ||
                        request()->routeIs('user.investment.plandetails'),
                ])
                    @if ($settings->spa_mode) wire:navigate @endif>
                    <span class="btn-inner--icon d-block"><i class="far fa-hand-holding-seedling fa-2x"></i></span>
                    <span class="pt-2 btn-inner--icon d-block">My Plans</span>
                </a>
            @endcan
        @endif

        @if ($mod['cryptoswap'] == 'true')
            <a href="{{ route('user.swap.assets') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.swap.*'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block"><i class="fab fa-stack-exchange fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Swap Crypto</span>
            </a>
        @endif
        @if ($mod['subscription'] == 'true')
            <a href="{{ route('user.copier.show') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.copier.*'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif">
                <span class="btn-inner--icon d-block"><i class="far fa-receipt fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Copytrading</span>
            </a>
        @endif
        @if ($mod['signal'] == 'true')
            <a href="{{ route('user.tradeSignals', ['page' => '1']) }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.tradeSignals'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block">
                    <i class="fas fa-wave-square fa-2x"></i>
                </span>
                <span class="pt-2 btn-inner--icon d-block">Trade Signals</span>
            </a>
        @endif
        @if ($mod['membership'] == 'true')
            <a href="{{ route('user.membership.courses', ['page' => 1]) }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.membership.*'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block"><i class="fas fa-graduation-cap fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Education</span>
            </a>
        @endif
        @can('refer users')
            <a href="{{ route('user.referral') }}" @class([
                'text-sm btn btn-square',
                'active' => request()->routeIs('user.referral'),
            ])
                @if ($settings->spa_mode) wire:navigate @endif>
                <span class="btn-inner--icon d-block"><i class="fas fa-retweet fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Referrals</span>
            </a>
        @endcan

    </div>
    @can('contact support')
        <!-- Misc area -->
        <div class="card bg-gradient-warning">
            <div class="card-body">
                <h5 class="text-white">Need Help!</h5>
                <p class="mb-4 text-white">
                    Contact our 24/7 customer support center
                </p>
                <a href="{{ route('user.contactsupport') }}" class="btn btn-sm btn-block btn-white rounded-pill"
                    @if ($settings->spa_mode) wire:navigate @endif>Contact Us</a>
            </div>
        </div>
    @endcan
</div>
