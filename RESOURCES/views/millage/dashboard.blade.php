@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-danger-alert />
    <x-success-alert />
    @if (!empty($settings->welcome_message) && auth()->user()->created_at->diffInDays() <= 3)
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-primary alert-dismissible fade show" role="alert">
                    {{ $settings->welcome_message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if ($settings->enable_annoucement && !empty($settings->annoucement))
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
                    {!! $settings->annoucement !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="text-center icon-big icon-primary bubble-shadow-small">
                                <i class="icon-wallet"></i>
                            </div>
                        </div>
                        <div class="ml-3 col col-stats ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Account balance</p>
                                <h4 class="card-title">
                                    {{ Number::currency(Auth::user()->account_bal, $settings->s_currency) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($mod['investment'])
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-success bubble-shadow-small">
                                    <i class="flaticon-coins"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Profit</p>
                                    <h4 class="card-title">
                                        {{ Number::currency(Auth::user()->roi, $settings->s_currency) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="text-center icon-big icon-secondary bubble-shadow-small">
                                <i class="flaticon-present"></i>
                            </div>
                        </div>
                        <div class="ml-3 col col-stats ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Bonus</p>
                                <h4 class="card-title">
                                    {{ Number::currency(Auth::user()->bonus, $settings->s_currency) }}
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
                                <i class="icon-share"></i>
                            </div>
                        </div>
                        <div class="ml-3 col col-stats ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Referral Bonus</p>
                                <h4 class="card-title">
                                    {{ Number::currency(Auth::user()->ref_bonus, $settings->s_currency) }}
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
                            <div class="text-center icon-big icon-warning bubble-shadow-small">
                                <i class="icon-arrow-down-circle"></i>
                            </div>
                        </div>
                        <div class="ml-3 col col-stats ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Deposit</p>
                                <h4 class="card-title">
                                    {{ Number::currency(auth()->user()->totalDeposits(), $settings->s_currency) }}
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
                            <div class="text-center icon-big icon-warning bubble-shadow-small">
                                <i class="icon-arrow-down-circle"></i>
                            </div>
                        </div>
                        <div class="ml-3 col col-stats ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Withdrawal</p>
                                <h4 class="card-title">
                                    {{ Number::currency(auth()->user()->totalWithdrawals(), $settings->s_currency) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($mod['subscription'] == 'true')
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="text-center icon-big icon-info bubble-shadow-small">
                                    <i class="icon-book-open"></i>
                                </div>
                            </div>
                            <div class="ml-3 col col-stats ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Trading Accounts</p>
                                    <h4 class="card-title">
                                        {{ auth()->user()->tradingAccounts()->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @can('see trade chart on dashboard')
        <div class="row" wire:ignore>
            <div class="col-md-12">
                <div>
                    <h4 class="font-weight-bold">Fundamental & Technical Outlook</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Track all
                                    markets</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
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
        </div>
    @endcan

    @if ($mod['investment'] == 'true')
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h4 class="font-weight-bold">Active Plan(s)</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        @forelse ($plans as $plan)
                            <div class="card-list">
                                <a href="{{ route('user.investment.plandetails', ['plan' => $plan]) }}"
                                    class=" text-decoration-none"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <div class="mb-2 border item-list d-flex">
                                        <div class="ml-3 info-user text-decoration-none">
                                            <div class="username font-weight-bolder">
                                                {{ $plan->plan->name }}
                                            </div>
                                            <div class="status">
                                                <h5 class="text-muted font-weight-bold">
                                                    {{ Number::currency($plan->amount, $settings->s_currency) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="pr-3">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="text-center">
                                <p>You do not have an active investment plan at the moment.</p>
                                <a href="{{ route('user.investment.buyplan') }}" class="btn btn-primary"
                                    @if ($settings->spa_mode) wire:navigate @endif>Buy a
                                    plan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="nk-block-head-content">
                <h4 class="font-weight-bold">
                    Recent transactions
                </h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 text-right">
                        <a href="{{ route('user.transactions.deposit') }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            View All
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-light">
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($history as $item)
                                    <tr>
                                        <td> {{ Number::currency($item->amount, $settings->s_currency) }}</td>
                                        <td>
                                            {{ $item->created_at->toDayDateTimeString() }}
                                        </td>
                                        <td>
                                            <span @class([
                                                'badge',
                                                'badge-success' => $item->type == 'Credit',
                                                'badge-danger' => $item->type == 'Debit',
                                            ])>
                                                {{ $item->type }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4">
                                        No record yet
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
