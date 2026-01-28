@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')

<div>
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Welcome, {{ Auth::user()->name }}!</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    @if (!empty($settings->welcome_message) && auth()->user()->created_at->diffInDays() <= 3)
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
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
                <div class="py-1 alert alert-info alert-dismissible fade show" role="alert">
                    {!! $settings->annoucement !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="p-2 card-body p-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="nk-block-head-content">
                                <h5 class="text-primary h5">Account Summary</h5>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Account balance</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                {{ Number::currency(Auth::user()->account_bal, $settings->s_currency) }}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                <i class="fas fa-sack-dollar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($mod['investment'] == 'true')
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mb-1 text-muted">Total Profit</h6>
                                                <span class="mb-0 h5 font-weight-bold">
                                                    {{ Number::currency(Auth::user()->roi, $settings->s_currency) }}
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                    <i class="fas fa-coins"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Bonus</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                {{ Number::currency(Auth::user()->bonus, $settings->s_currency) }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                <i class="fas fa-gift"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($mod['subscription'] == 'true')
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mb-1 text-muted">Trading Accounts</h6>
                                                <span
                                                    class="mb-0 h5 font-weight-bold">{{ auth()->user()->tradingAccounts()->count() }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                    <i class="fas fa-th-list"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Referral Bonus</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                {{ Number::currency(Auth::user()->ref_bonus, $settings->s_currency) }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                <i class="fas fa-gifts"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Total Deposit</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                <span class="mb-0 h5 font-weight-bold ">
                                                    {{ Number::currency(auth()->user()->totalDeposits(), $settings->s_currency) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                <i class="fas fa-arrow-alt-circle-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Total Withdrawal</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                {{ Number::currency(auth()->user()->totalWithdrawals(), $settings->s_currency) }}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-primary rounded-circle icon-shape">
                                                <i class="fas fa-arrow-circle-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('see trade chart on dashboard')
                        <div class="row d-none d-lg-block">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="nk-block-head-content">
                                            <h5 class="text-primary h5">Fundamental & Technical Outlook</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="home-tab" data-toggle="tab"
                                                    data-target="#home" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    style="color:#222; padding:5px;">Track all
                                                    markets</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-toggle="tab"
                                                    data-target="#profile" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false"
                                                    style="color:#222; padding:5px;">Personal
                                                    trading chart</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                aria-labelledby="home-tab">
                                                <!-- TradingView Widget BEGIN -->
                                                <div class="tradingview-widget-container">
                                                    <div class="tradingview-widget-container__widget"></div>
                                                    <div class="tradingview-widget-copyright"></div>
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
                                            <div class="tab-pane fade" id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab">
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
                                <div class="nk-block-head-content">
                                    <h5 class="text-primary h5">Active Plans</h5>
                                </div>
                                @forelse ($plans as $plan)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="py-4 card">
                                                <div
                                                    class="card-body d-flex justify-content-between align-items-center">

                                                    <div class="">
                                                        <h6 class="text-black h6">{{ $plan->plan->name }}
                                                        </h6>
                                                        <p class="text-muted h5">
                                                            <span class="amount">
                                                                {{ Number::currency($plan->amount, $settings->s_currency) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="d-none d-lg-block">
                                                        <div class="d-flex justify-content-around">
                                                            <div class="mr-3">
                                                                <h6 class="text-black bold">
                                                                    {{ $plan->created_at->format('d M, Y') }}
                                                                </h6>
                                                                <span class="nk-iv-scheme-value date">Start
                                                                    Date</span>
                                                            </div>
                                                            <i class="fas fa-arrow-right text-muted"></i>
                                                            <div class="ml-3">
                                                                <h6 class="text-black bold">
                                                                    {{ $plan->expire_date->format('d M, Y') }}
                                                                </h6>
                                                                <span class="nk-iv-scheme-value date">End
                                                                    Date</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <span class="badge badge-success d-block">Active</span>
                                                        <span class="nk-iv-scheme-value amount">Status</span>
                                                    </div>

                                                    <a href="{{ route('user.investment.plandetails', ['plan' => $plan]) }}"
                                                        @if ($settings->spa_mode) wire:navigate @endif>
                                                        <i class="fas fa-chevron-right fa-2x"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="py-4 card">
                                                <div class="text-center card-body">
                                                    <p>
                                                        You do not have an active investment plan at the
                                                        moment.
                                                    </p>
                                                    <a href="{{ route('user.investment.buyplan') }}"
                                                        class="px-3 btn btn-primary"
                                                        @if ($settings->spa_mode) wire:navigate @endif>Buy a
                                                        plan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="nk-block-head-content">
                                <h6 class="text-primary h5">
                                    Recent transactions
                                </h6>
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
                                                        <td> {{ Number::currency($item->amount, $settings->s_currency) }}
                                                        </td>
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
                    <div class="mt-4 row" x-data="{
                        address: '{{ Auth::user()->refferal_link }}',
                        copyToClipboard(text) {
                            if (!navigator.clipboard) {
                                return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                            }
                            navigator.clipboard.writeText(text)
                                .then(() => {
                                    alert('Copied');
                                })
                        },
                    }">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-black">Refer Us & Earn</h5>
                                    <p>Use the below link to invite your friends.</p>
                                    <div class="mb-3 input-group">
                                        <input type="text" class="form-control myInput readonly"
                                            value="{{ Auth::user()->refferal_link }}" id="key-02" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button"
                                                x-on:click="copyToClipboard(address)" data-clipboard-target="#key-02">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
