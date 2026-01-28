<!-- Stored in resources/views/child.blade.php -->

<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="light">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->name }}
                            <span class="user-level"> Admin</span>
                            {{-- <span class="caret"></span> --}}
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" @if ($settings->spa_mode) wire:navigate @endif>
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if ($mod['investment'] == 'true')
                    @can('view investment plan')
                        <li @class([
                            'nav-item ',
                            'active' =>
                                request()->routeIs('admin.investmentPlans') ||
                                request()->routeIs('admin.usersPlans'),
                        ])>
                            <a data-toggle="collapse" href="#pln">
                                <i class="fas fa-cubes "></i>
                                <p>Investment</p>
                                <span class="caret"></span>
                            </a>
                            <div @class([
                                'collapse',
                                'show' =>
                                    request()->routeIs('admin.investmentPlans') ||
                                    request()->routeIs('admin.usersPlans'),
                            ]) id="pln">
                                <ul class="nav nav-collapse">
                                    <li @class(['active' => request()->routeIs('admin.investmentPlans')])>
                                        <a href="{{ route('admin.investmentPlans') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">Plans</span>
                                        </a>
                                    </li>
                                    @can('view users plan')
                                        <li @class(['active' => request()->routeIs('admin.usersPlans')])>
                                            <a href="{{ route('admin.usersPlans') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Users Investments</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                @can('view users')
                    <li @class(['nav-item ', 'active' => request()->routeIs('admin.users.*')])>
                        <a data-toggle="collapse" href="#users">
                            <i class="fas fa-users-cog" aria-hidden="true"></i>
                            <p>Manage Users</p>
                            <span class="caret"></span>
                        </a>
                        <div @class(['collapse', 'show' => request()->routeIs('admin.users.*')]) id="users">
                            <ul class="nav nav-collapse">
                                <li @class(['active' => request()->routeIs('admin.users.listUsers')])>
                                    <a href="{{ route('admin.users.listUsers') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <span class="sub-item">Users List</span>
                                    </a>
                                </li>
                                @can('create user')
                                    <li @class(['active' => request()->routeIs('admin.users.add')])>
                                        <a href="{{ route('admin.users.add') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">Add User</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('view deposits')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('admin.manageDeposits'),
                    ])>
                        <a href="{{ route('admin.manageDeposits') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <p>Manage Deposits</p>
                        </a>
                    </li>
                @endcan

                @can('view withdrawals')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('admin.manageWithdrawal'),
                    ])>
                        <a href="{{ route('admin.manageWithdrawal') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fa fa-arrow-alt-circle-up" aria-hidden="true"></i>
                            <p>Manage Withdrawal</p>
                        </a>
                    </li>
                @endcan
                @can('view transactions')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('admin.usersTransactions'),
                    ])>
                        <a href="{{ route('admin.usersTransactions') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                            <p>Transactions</p>
                        </a>
                    </li>
                @endcan
                @can('view kyc applications')
                    <li @class([
                        'nav-item',
                        'active' =>
                            request()->routeIs('admin.kycApplications') ||
                            request()->routeIs('admin.processKycApplication'),
                    ])>
                        <a href="{{ route('admin.kycApplications') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fa fa-user-check" aria-hidden="true"></i>
                            <p>KYC Application(s)</p>
                        </a>
                    </li>
                @endcan
                @if ($mod['subscription'] == 'true')
                    @can('see copytrade menu')
                        <li @class([
                            'nav-item',
                            'active' => request()->routeIs('admin.copytrading.*'),
                        ])>
                            <a data-toggle="collapse" href="#copytrade">
                                <i class="fa fa-sync-alt"></i>
                                <p>CopyTrade</p>
                                <span class="caret"></span>
                            </a>
                            <div @class([
                                'collapse',
                                'show' => request()->routeIs('admin.copytrading.*'),
                            ]) id="copytrade">
                                <ul class="nav nav-collapse">
                                    @can('view providers')
                                        @if ($settings->use_copytrade)
                                            <li @class([
                                                'active' => request()->routeIs('admin.copytrading.providers'),
                                            ])>
                                                <a href="{{ route('admin.copytrading.providers') }}"
                                                    @if ($settings->spa_mode) wire:navigate @endif>
                                                    <span class="sub-item">Provider accounts</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endcan
                                    @can('manage subscribers')
                                        <li @class([
                                            'active' => request()->routeIs('admin.copytrading.subscribers'),
                                        ])>
                                            <a href="{{ route('admin.copytrading.subscribers') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Subcriber accounts</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view symbolmaps')
                                        @if ($settings->use_copytrade)
                                            <li @class([
                                                'active' => request()->routeIs('admin.copytrading.symbolmaps'),
                                            ])>
                                                <a href="{{ route('admin.copytrading.symbolmaps') }}"
                                                    @if ($settings->spa_mode) wire:navigate @endif>
                                                    <span class="sub-item">Symbol Maps</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endcan
                                    @can('manage copytrade settings')
                                        <li @class([
                                            'active' => request()->routeIs('admin.copytrading.settings'),
                                        ])>
                                            <a href="{{ route('admin.copytrading.settings') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Settings</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                @if ($mod['signal'] == 'true')
                    @can('see signal menu')
                        <li @class(['nav-item', 'active' => request()->routeIs('admin.signal.*')])>
                            <a data-toggle="collapse" href="#signals">
                                <i class="fa fa-signal"></i>
                                <p>Signal Provider</p>
                                <span class="caret"></span>
                            </a>
                            <div id="signals" @class(['collapse', 'show' => request()->routeIs('admin.signal.*')])>
                                <ul class="nav nav-collapse">
                                    @can('manage signals')
                                        <li @class([
                                            'active' => request()->routeIs('admin.signal.signals'),
                                        ])>
                                            <a href="{{ route('admin.signal.signals', ['page' => 1]) }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Trade Signals</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage signal subscribers')
                                        <li @class([
                                            'active' => request()->routeIs('admin.signal.subscribers'),
                                        ])>
                                            <a href="{{ route('admin.signal.subscribers', ['page' => 1]) }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Subscribers</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage signal settings')
                                        <li @class([
                                            'active' => request()->routeIs('admin.signal.settings'),
                                        ])>
                                            <a href="{{ route('admin.signal.settings') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Settings</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                @if ($mod['membership'] == 'true')
                    @can('see membership menu')
                        <li @class([
                            'nav-item',
                            'active' => request()->routeIs('admin.membership.*'),
                        ])>
                            <a data-toggle="collapse" href="#meme">
                                <i class="fa fa-book-reader"></i>
                                <p>Education(LMS)</p>
                                <span class="caret"></span>
                            </a>
                            <div @class([
                                'collapse',
                                'show' => request()->routeIs('admin.membership.*'),
                            ]) id="meme">
                                <ul class="nav nav-collapse">
                                    @can('manage categories')
                                        <li @class([
                                            'active' => request()->routeIs('admin.membership.categories'),
                                        ])>
                                            <a href="{{ route('admin.membership.categories') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Categories</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage courses')
                                        <li @class([
                                            'active' =>
                                                request()->routeIs('admin.membership.courses') ||
                                                request()->routeIs('admin.membership.courseLessons'),
                                        ])>
                                            <a href="{{ route('admin.membership.courses', ['page' => 1]) }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Courses</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage lessons')
                                        <li @class([
                                            'active' => request()->routeIs('admin.membership.lessons'),
                                        ])>
                                            <a href="{{ route('admin.membership.lessons') }}">
                                                <span class="sub-item">Lessons</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                @if ($mod['cryptoswap'] == 'true')
                    @can('see crypto swap menu')
                        <li @class(['nav-item', 'active' => request()->routeIs('admin.swap.*')])>
                            <a data-toggle="collapse" href="#swap">
                                <i class="fas fa-vector-square"></i>
                                <p>Crypto Swap</p>
                                <span class="caret"></span>
                            </a>
                            <div id="swap" @class(['collapse', 'show' => request()->routeIs('admin.swap.*')])>
                                <ul class="nav nav-collapse">
                                    @can('manage assets')
                                        <li @class([
                                            'active' => request()->routeIs('admin.swap.assets'),
                                        ])>
                                            <a href="{{ route('admin.swap.assets', ['page' => 1]) }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Manage Assets</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage swap settings')
                                        <li @class([
                                            'active' => request()->routeIs('admin.swap.settings'),
                                        ])>
                                            <a href="{{ route('admin.swap.settings') }}"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <span class="sub-item">Settings</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                @can('view tasks assigned to them')
                    <li @class(['nav-item', 'active' => request()->routeIs('admin.crm.*')])>
                        <a data-toggle="collapse" href="#task">
                            <i class="fas fa-align-center"></i>
                            <p>CRM</p>
                            <span class="caret"></span>
                        </a>
                        <div @class(['collapse', 'show' => request()->routeIs('admin.crm.*')]) id="task">
                            <ul class="nav nav-collapse">
                                @can('view tasks assigned to them')
                                    <li @class(['active' => request()->routeIs('admin.crm.tasks')])>
                                        <a href="{{ route('admin.crm.tasks') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">Tasks</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('send emails')
                                    <li @class(['active' => request()->routeIs('admin.crm.sendMail')])>
                                        <a href="{{ route('admin.crm.sendMail') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <span class="sub-item">Send Email</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('view settings')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('admin.settings.*'),
                    ])>
                        <a href="{{ route('admin.settings.index') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="fa fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                @endcan

                @can('view platform administration')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('admin.platform.*'),
                    ])>
                        <a href="{{ route('admin.platform.index') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class=" fas fa-box" aria-hidden="true"></i>
                            <p>Platform Administration</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
