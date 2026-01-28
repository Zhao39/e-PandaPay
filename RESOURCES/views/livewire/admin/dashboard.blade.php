@use('\Illuminate\Support\Number', 'Number')
<x-slot:title>
    Dashboard Overview
</x-slot:title>
<x-slot:styles>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</x-slot:styles>
<div>
    <div class="mt-2 mb-4">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-lg-row">
            <div class="mt-2 mb-1">
                <h2>
                    Welcome, <span class="font-weight-bold">{{ auth()->user()->name }}!</span>
                </h2>
                <small class="text-muted">{{ $quote }}</small>
            </div>
            <div class="py-2 ml-md-auto py-md-0">
                @can('view deposits')
                    <a href="{{ route('admin.manageDeposits') }}" @if ($settings->spa_mode) wire:navigate @endif
                        class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                        Deposits
                    </a>
                @endcan
                @can('view withdrawals')
                    <a href="{{ route('admin.manageWithdrawal') }}" @if ($settings->spa_mode) wire:navigate @endif
                        class="btn btn-danger btn-sm">
                        <i class="bi bi-arrow-up-right-circle-fill"></i>
                        Withdrawals
                    </a>
                @endcan
                @can('view users')
                    <a href="{{ route('admin.users.listUsers') }}" @if ($settings->spa_mode) wire:navigate @endif
                        class="btn btn-dark btn-sm">
                        <i class="bi bi-people-fill"></i>
                        Users
                    </a>
                @endcan
            </div>
        </div>
    </div>
    @can('view admin dashboard stats')
        <!-- Beginning of  Dashboard Stats  -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-primary bubble-shadow-small">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total users</p>
                                    <h4 class="card-title">{{ Number::abbreviate($numberOfUsers) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-info bubble-shadow-small">
                                    <i class="bi bi-receipt"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active Invesments</p>
                                    <h4 class="card-title">{{ Number::abbreviate($subscribers) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-danger bubble-shadow-small">
                                    <i class="bi bi-arrow-up-right-circle-fill"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total withdrawals</p>
                                    <h4 class="card-title">
                                        {{ Number::currency($total_withdrawn, $settings->s_currency) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-success bubble-shadow-small">
                                    <i class="bi bi-arrow-down-circle-fill"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total deposits</p>
                                    <h4 class="card-title">
                                        {{ Number::currency($total_deposited, $settings->s_currency) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-danger bubble-shadow-small">
                                    <i class="bi bi-person-fill-slash"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Blocked users</p>
                                    <h4 class="card-title">{{ Number::abbreviate($blockedusers) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-success bubble-shadow-small">
                                    <i class="bi bi-person-check"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active users</p>
                                    <h4 class="card-title">{{ Number::format($active_users) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-warning bubble-shadow-small">
                                    <i class="flaticon-graph"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending withdrawals</p>
                                    <h4 class="card-title">
                                        {{ Number::currency($chart_pendwithdraw, $settings->s_currency) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-primary bubble-shadow-small">
                                    <i class="flaticon-success"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending deposits</p>
                                    <h4 class="card-title">
                                        {{ Number::currency($chart_pendepsoit, $settings->s_currency) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Dashboard Stats  -->
    @endcan
    @can('view users registration chart')
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="height: 450px">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0 font-weight-bold">Users Statistics</h4>
                            <small class="mt-0">Reload page if chart is not visible.</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <x-spinner wire:loading wire:target='year' />
                            <select class="form-control" wire:model.live='year'>
                                @foreach ($years as $year)
                                    <option>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:livewire-column-chart key="{{ $regChart->reactiveKey() }}" :column-chart-model="$regChart" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body" style="height: 450px; overflow-y: auto">
                        <div>
                            <h4 class="font-weight-bold">
                                Recent Sessions
                                <i class="bi bi-circle-fill text-success"></i>
                            </h4>
                        </div>
                        <div class="card-list">
                            @foreach ($usersOnline as $user)
                                @if (!is_null($user))
                                    <a href="{{ route('admin.users.singleUser', ['user' => $user]) }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <div class="shadow-sm item-list d-flex">
                                            <div class="ml-3 info-user text-decoration-none">
                                                <div class="username font-weight-bolder">{{ $user->name }}</div>
                                                <div class="status">{{ $user->email }}</div>
                                            </div>
                                            <div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <div class="row">
        @can('view activty log')
            <div class="col-md-8">
                <div class="card full-height">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold">Activity Log</h4>
                        </div>
                        <div>
                            <a href="{{ route('admin.platform.activitiesLog') }}"
                                @if ($settings->spa_mode) wire:navigate @endif>View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ol class="activity-feed">
                            @foreach ($activities as $activity)
                                <li class="feed-item feed-item-secondary d-lg-flex justify-content-between">
                                    <div>
                                        <time class="date" datetime="9-25">
                                            {{ $activity->created_at->toDayDateTimeString() }}
                                        </time>
                                        <span class="text">
                                            {{ $activity->description }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text">
                                            <i class="bi bi-person"></i>
                                            {{-- {{ $activity->causer->name }} --}}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                        @if ($activities->count() < 1)
                            <div class="text-center">
                                <x-no-data />
                                <h4 class=" font-weight-bold">No Activity Logged.</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
        @can('view other stats')
            <div class="col-md-4">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title fw-mediumbold">
                            <h4 class="font-weight-bold">Suggested Users</h4>
                        </div>
                        <div class="card-list">
                            @foreach ($randomUsers as $user)
                                <div class="item-list">
                                    <div class="avatar">
                                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                            alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    <div class="ml-3 info-user">
                                        <div class="username">{{ $user->name }}</div>
                                        <div class="status">{{ $user->email }}</div>
                                    </div>
                                    @can('edit user')
                                        <a href="{{ route('admin.users.singleUser', ['user' => $user]) }}" class=""
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    @can('view other stats')
        <div class="row">
            <div class="col-lg-8">
                <div class="card" style="height: 500px">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4 class="font-weight-bold">Transactions</h4>
                            <small class="mt-0">Reload page if chart is not visible.</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <x-spinner wire:loading />
                            <select class="form-control" wire:model.live='yearr'>
                                @foreach ($years as $year)
                                    <option>{{ $year }}</option>
                                @endforeach
                            </select>
                            <span class="mx-2">-</span>
                            <select class="form-control" wire:model.live='month'>
                                <option value="All">All</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:livewire-line-chart key="{{ $tranChart->reactiveKey() }}" :line-chart-model="$tranChart" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="height: 500px">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4 class="font-weight-bold">Top Performing Investments:</h4>
                        </div>
                    </div>
                    <div class="pb-0 card-body">
                        @forelse ($topPerformingInv as $item)
                            <div class="d-flex">
                                <div class="flex-1 pt-1 ml-2">
                                    <h6 class="mb-1 fw-bold">{{ $item->user->name }}</h6>
                                    <small class="text-muted">{{ $item->plan->name }}</small>
                                </div>
                                <div class="ml-auto d-flex align-items-center">
                                    <h3 class="text-info fw-bold">
                                        {{ Number::currency($item->profit_earned, $settings->s_currency) }}
                                    </h3>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <div class="separator-dashed"></div>
                            @endif
                        @empty
                            <div class="text-center">
                                <h5 class="font-weight-bold">No Active Investment</h5>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endcan

</div>

<x-slot:scripts>
    @livewireChartsScripts
</x-slot:scripts>
