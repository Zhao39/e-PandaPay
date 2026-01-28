<div>
    @if ($metrics)
        <div class="row g-6">
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Equity</h5>
                            <div>
                                <span class="badge bg-info">
                                    <i class="bi bi-activity"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'equity') ? Number::format(floatval($metrics['equity']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Profit</h5>
                            <div>
                                <span class="badge bg-success">
                                    <i class="bi bi-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            {{ Arr::exists($metrics, 'profit') ? Number::format(floatval($metrics['profit']), 2) : 'Not Available' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Balance</h5>
                            <div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-wallet"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'balance') ? Number::format(floatval($metrics['balance']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Highest Balance</h5>
                            <div>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-cash-stack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'highestBalance') ? Number::format(floatval($metrics['highestBalance']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Highest Balance Date</h5>
                            <div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'highestBalanceDate') ? \Carbon\Carbon::parse($metrics['highestBalanceDate'])->toDayDateTimeString() : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Margin</h5>
                            <div>
                                <span class="badge bg-danger">
                                    <i class="bi bi-terminal-fill"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'margin') ? Number::format(floatval($metrics['margin']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Free Margin</h5>
                            <div>
                                <span class="badge bg-warning">
                                    <i class="bi bi-terminal-fill"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'freeMargin') ? Number::format(floatval($metrics['freeMargin']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Trades</h5>
                            <div>
                                <span class="badge bg-primary">
                                    <i class="bi bi-stack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'trades') ? Number::format(floatval($metrics['trades'])) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Won Trades</h5>
                            <div>
                                <span class="badge bg-success">
                                    <i class="bi bi-stack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'wonTrades') ? Number::format(floatval($metrics['wonTrades'])) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Lost Trades</h5>
                            <div>
                                <span class="badge bg-danger">
                                    <i class="bi bi-stack"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'lostTrades') ? Number::format(floatval($metrics['lostTrades'])) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Deposits</h5>
                            <div>
                                <span class="badge bg-success">
                                    <i class="bi bi-bank"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'deposits') ? Number::format(floatval($metrics['deposits']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class=" font-weight-bolder">Withdrawalal</h5>
                            <div>
                                <span class="badge bg-danger">
                                    <i class="bi bi-box-arrow-in-up-right"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p>
                                {{ Arr::exists($metrics, 'withdrawals') ? Number::format(floatval($metrics['withdrawals']), 2) : 'Not Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (is_null($metrics))
        <div class="card">
            <div class="text-center card-body">
                <h6 class="font-weight-bold">
                    We are unable to retrieve metrics for this account, please check later.
                </h6>
            </div>
        </div>
    @endif
</div>
