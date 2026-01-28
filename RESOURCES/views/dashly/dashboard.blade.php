@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <!-- Title -->
    <h1 class="h2">
        Welcome, {{ Auth::user()->name }}!
    </h1>
    <x-danger-alert />
    <x-success-alert />
    @if (!empty($settings->welcome_message) and Auth::user()->created_at->diffInDays() <= 3)
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-primary alert-dismissible fade show" role="alert">
                    {{ $settings->welcome_message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if ($settings->enable_annoucement == 'on' and !empty($settings->annoucement))
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
                    {!! $settings->annoucement !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3">
            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-primary"></span>
                                    Account Balance
                                </h5>

                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ Number::currency(Auth::user()->account_bal, $settings->s_currency) }}
                                </h2>

                                <a href="{{ route('user.deposit.make') }}" class="mt-2 mb-0 mr-3 fs-6 btn-link"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    Deposit
                                </a>
                                <span class="">-</span>
                                @if ($settings->use_transfer)
                                    <a href="{{ route('user.transferfund') }}" class="mt-2 mb-0 ml-3 fs-6 btn-link"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        Transfer
                                    </a>
                                @endif
                            </div>

                            <span class="text-primary">
                                <i class="bi bi-wallet-fill fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        @if ($mod['investment'] == 'true')
            <div class="col-lg-3">
                <!-- Card -->
                <div class="border-0 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                        <span class="legend-circle-sm bg-success"></span>
                                        Total Profit
                                    </h5>
                                    <!-- Subtitle -->
                                    <h2 class="mb-0 h3">
                                        {{ Number::currency(Auth::user()->roi, $settings->s_currency) }}
                                    </h2>
                                    <!-- Comment -->
                                    <a href="{{ route('user.investment.myplans') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <p class="mt-2 mb-0 fs-6 btn-link">
                                            View profit history
                                        </p>
                                    </a>
                                </div>

                                <span class="text-success">
                                    <i class="bi bi-coin fs-1"></i>
                                </span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-3">
            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-info"></span>
                                    Total Bonus
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ Number::currency(Auth::user()->bonus, $settings->s_currency) }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('user.transactions.others') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <p class="mt-2 mb-0 fs-6 btn-link">
                                        View bonus history
                                    </p>
                                </a>
                            </div>

                            <span class="text-info">
                                <i class="bi bi-gift-fill fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-info"></span>
                                    Referral Bonus
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ Number::currency(Auth::user()->ref_bonus, $settings->s_currency) }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('user.referral') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <p class="mt-2 mb-0 fs-6 btn-link">
                                        View referrals
                                    </p>
                                </a>
                            </div>

                            <span class="text-info">
                                <i class="bi bi-piggy-bank fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-success"></span>
                                    Total Deposited
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ Number::currency(auth()->user()->totalDeposits(), $settings->s_currency) }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('user.transactions.deposit') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <p class="mt-2 mb-0 fs-6 btn-link">
                                        View deposits
                                    </p>
                                </a>
                            </div>

                            <span class="text-success">
                                <i class="bi bi-box-arrow-in-down fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-danger"></span>
                                    Total Withdrawal
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ Number::currency(auth()->user()->totalWithdrawals(), $settings->s_currency) }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('user.transactions.withdrawal') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <p class="mt-2 mb-0 fs-6 btn-link">
                                        View withdrawals
                                    </p>
                                </a>
                            </div>

                            <span class="text-danger">
                                <i class="bi bi-box-arrow-in-up fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="border-0 card">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                    <span class="legend-circle-sm bg-secondary"></span>
                                    Referrals
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0 h3">
                                    {{ $referrals }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('user.referral') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <p class="mt-2 mb-0 fs-6 btn-link">
                                        View referrals
                                    </p>
                                </a>
                            </div>
                            <span class="text-secondary">
                                <i class="bi bi-link fs-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($mod['subscription'] == 'true')
            <div class="col-lg-3">
                <div class="border-0 card">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h5
                                        class="mb-2 h6 d-flex align-items-center text-uppercase text-muted fw-semibold">
                                        <span class="legend-circle-sm bg-info"></span>
                                        Managed Accounts
                                    </h5>
                                    <!-- Subtitle -->
                                    <h2 class="mb-0 h3">
                                        {{ auth()->user()->tradingAccounts()->count() }}
                                    </h2>
                                    <!-- Comment -->
                                    <a href="{{ route('user.copier.show') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <p class="mt-2 mb-0 fs-6 btn-link">
                                            View accounts
                                        </p>
                                    </a>
                                </div>

                                <span class="text-info">
                                    <i class="bi bi-bar-chart-steps fs-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if ($mod['investment'] == 'true')
        {{-- Active Investment plans section --}}
        <div class="row">
            <div class="col-12">
                <h5 class="mb-0 text-primary h5">Active Plan(s)
                    <span class="text-base count">({{ $plans ? count($plans) : '0' }})</span>
                </h5>
            </div>
            <div class="col-12">
                @forelse ($plans as $plan)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="h5">{{ $plan->plan->name }}</h6>
                                        <p class="h3">
                                            {{ Number::currency($plan->amount, $settings->s_currency) }}
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <div class="d-flex justify-content-around">
                                            <div class="mr-3">
                                                <h6 class="text-black bold">
                                                    {{ $plan->created_at->format('d M, Y') }}
                                                </h6>
                                                <span class="nk-iv-scheme-value date">Start Date</span>
                                            </div>
                                            <span class="m-3">

                                            </span>
                                            <div class="ml-3">
                                                <h6 class="text-black bold">
                                                    {{ $plan->expire_date->format('d M, Y') }}
                                                </h6>
                                                <span class="nk-iv-scheme-value date">End Date</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-black">
                                            @if ($plan->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($plan->status == 'expired')
                                                <span class="badge bg-danger">Expired</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </h6>
                                        <span class="nk-iv-scheme-value amount">Status</span>
                                    </div>

                                    <a href="{{ route('user.investment.plandetails', ['plan' => $plan]) }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <i class="bi bi-arrow-right fs-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mt-4 row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="py-4 text-center card-body">
                                    <i class="bi bi-database-fill-exclamation" style="font-size: 60px"></i>
                                    <p>You do not have an active investment at the moment.</p>
                                    <a href="{{ route('user.investment.buyplan') }}" class="btn btn-primary"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        Invest Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{-- end of active investmet and purchase of investment plan --}}
    @endif
    {{-- 10 Recent transaction begin --}}
    <div class="row">
        <div class="mb-2 col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-primary h5">
                    Recent transactions
                </h6>
                <div>
                    <a href="{{ route('user.transactions.deposit') }}" class="btn btn-primary btn-sm"
                        @if ($settings->spa_mode) wire:navigate @endif>
                        View transactions
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($history as $item)
                                    <tr>
                                        <td>
                                            {{ $item->created_at->format('d M, Y') }}
                                        </td>
                                        <td>
                                            <span @class([
                                                'badge',
                                                'bg-success' => $item->type == 'Credit',
                                                'bg-danger' => $item->type == 'Debit',
                                            ])>
                                                {{ $item->type }}
                                            </span>
                                        </td>
                                        <td> {{ Number::currency($item->amount, $settings->s_currency) }}</td>
                                    </tr>
                                @empty
                                    <td colspan="3">
                                        No record yet
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('see trade chart on dashboard')
            <div class="col-md-12">
                <h4 class="fw-bold">Fundamental & Technical Outlook</h4>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Track all
                                    markets</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">Personal
                                    trading chart</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/"
                                            rel="noopener nofollow" target="_blank"><span class="blue-text">Track all
                                                markets
                                                on
                                                TradingView</span></a></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js"
                                        async>
                                        {
                                            "width": "100%",
                                            "height": "550",
                                            "currencies": [
                                                "EUR",
                                                "USD",
                                                "JPY",
                                                "GBP",
                                                "CHF",
                                                "AUD",
                                                "CAD",
                                                "NZD",
                                                "CNY",
                                                "TRY",
                                                "SEK",
                                                "NOK"
                                            ],
                                            "isTransparent": true,
                                            "colorTheme": "light",
                                            "locale": "en"
                                        }
                                    </script>
                                </div>
                                <!-- TradingView Widget END -->
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tradingview-widget-container">
                                    <div id="tradingview_f933e"></div>
                                    <div class="tradingview-widget-copyright">

                                        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                        <script type="text/javascript">
                                            new TradingView.widget({
                                                "width": "100%",
                                                "height": "550",
                                                "symbol": "COINBASE:BTCUSD",
                                                "interval": "1",
                                                "timezone": "Etc/UTC",
                                                "theme": 'light',
                                                "style": "9",
                                                "locale": "en",
                                                "toolbar_bg": "#f1f3f6",
                                                "enable_publishing": false,
                                                "hide_side_toolbar": false,
                                                "allow_symbol_change": true,
                                                "calendar": false,
                                                "studies": [
                                                    "BB@tv-basicstudies"
                                                ],
                                                "container_id": "tradingview_f933e"
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>
    {{-- end of recent transactions --}}

</div>
