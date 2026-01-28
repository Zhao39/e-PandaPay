<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->name }}
                            <span class="user-level"> {{ auth()->user()->email }}</span>
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li @class(['nav-item', 'active' => request()->routeIs('user.dashboard')])>
                    <a href="{{ route('user.dashboard') }}" @if ($settings->spa_mode) wire:navigate @endif>
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @can('make deposit')
                    <li @class(['nav-item', 'active' => request()->routeIs('user.deposit.*')])>
                        <a href="{{ route('user.deposit.make') }}" @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-angle-double-down"></i>
                            <p>Deposit</p>
                        </a>
                    </li>
                @endcan

                @can('make withdrawal')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('user.withdraw.request'),
                    ])>
                        <a href="{{ route('user.withdraw.request') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-arrow-alt-circle-up "></i>
                            <p>Withdraw</p>
                        </a>
                    </li>
                @endcan
                @can('see their transactions history')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('user.transactions.*'),
                    ])>
                        <a href="{{ route('user.transactions.deposit') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-money-check-alt "></i>
                            <p>Transactions</p>
                        </a>
                    </li>
                @endcan

                @if ($settings->use_transfer)
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('user.transferfund'),
                    ])>
                        <a href="{{ route('user.transferfund') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-bezier-curve"></i>
                            <p>Transfer funds</p>
                        </a>
                    </li>
                @endif

                @if ($mod['investment'] == 'true')
                    <li @class([
                        'nav-item ',
                        'active' => request()->routeIs('user.investment.*'),
                    ])>
                        <a data-toggle="collapse" href="#pln">
                            <i class="fas fa-cubes "></i>
                            <p>Investment Plan</p>
                            <span class="caret"></span>
                        </a>
                        <div @class([
                            'collapse',
                            'show' => request()->routeIs('user.investment.*'),
                        ]) id="pln">
                            <ul class="nav nav-collapse">
                                @can('purchase plan')
                                    <li @class(['active' => request()->routeIs('user.investment.buyplan')])>
                                        <a href="{{ route('user.investment.buyplan') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">Buy a plan</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('see their plans')
                                    <li @class([
                                        'active' =>
                                            request()->routeIs('user.investment.myplans') ||
                                            request()->routeIs('user.investment.plandetails'),
                                    ])>
                                        <a href="{{ route('user.investment.myplans') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">My Plans</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif
                @if ($mod['cryptoswap'] == 'true')
                    <li @class(['nav-item ', 'active' => request()->routeIs('user.swap.*')])>
                        <a data-toggle="collapse" href="#swap">
                            <i class="fab fa-stack-exchange"></i>
                            <p>Swap Crypto</p>
                            <span class="caret"></span>
                        </a>
                        <div @class(['collapse', 'show' => request()->routeIs('user.swap.*')]) id="swap">
                            <ul class="nav nav-collapse">
                                <li @class(['active' => request()->routeIs('user.swap.assets')])>
                                    <a href="{{ route('user.swap.assets') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <span class="sub-item">Assets</span>
                                    </a>
                                </li>
                                <li @class([
                                    'active' => request()->routeIs('user.swap.transactions'),
                                ])>
                                    <a href="{{ route('user.swap.transactions') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <span class="sub-item">Swap History</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if ($mod['subscription'] == 'true')
                    <li @class(['nav-item', 'active' => request()->routeIs('user.copier.*')])>
                        <a href="{{ route('user.copier.show') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-layer-group"></i>
                            <p>Copytrading</p>
                        </a>
                    </li>
                @endif

                @if ($mod['signal'] == 'true')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('user.tradeSignals'),
                    ])>
                        <a href="{{ route('user.tradeSignals', ['page' => '1']) }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-rss"></i>
                            <p>Trade Signals</p>
                        </a>
                    </li>
                @endif

                @if ($mod['membership'] == 'true')
                    <li @class([
                        'nav-item ',
                        'active' => request()->routeIs('user.membership.*'),
                    ])>
                        <a data-toggle="collapse" href="#mem">
                            <i class="fas fa-graduation-cap"></i>
                            <p>Education</p>
                            <span class="caret"></span>
                        </a>
                        <div @class([
                            'collapse',
                            'show' => request()->routeIs('user.membership.*'),
                        ]) id="mem">
                            <ul class="nav nav-collapse">
                                <li @class(['active' => request()->routeIs('user.membership.courses')])>
                                    <a href="{{ route('user.membership.courses', ['page' => '1']) }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <span class="sub-item">Courses</span>
                                    </a>
                                </li>
                                <li @class([
                                    'active' => request()->routeIs('user.membership.mycourses'),
                                ])>
                                    <a href="{{ route('user.membership.mycourses') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <span class="sub-item">My Courses</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @can('refer users')
                    <li @class(['nav-item', 'active' => request()->routeIs('user.referral')])>
                        <a href="{{ route('user.referral') }}" @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-retweet "></i>
                            <p>Referrals</p>
                        </a>
                    </li>
                @endcan
                @can('contact support')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('user.contactsupport'),
                    ])>
                        <a href="{{ route('user.contactsupport') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fa fa-envelope "></i>
                            <p> Contact Us</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
