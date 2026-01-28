@use('\Illuminate\Support\Arr', 'Arr')
@use('\Illuminate\Support\Number', 'Number')
<div>
    <div class="page-title">
        <div class="mb-3 row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Account Information</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="">Account <br>
                                <span class="text-muted">{{ $account->name }}</span>
                            </h5>
                            <h5 class="">Account ID: <br>
                                <span class="text-muted">{{ $account->login }}</span>
                            </h5>
                            <h5 class="">Account Platform: <br>
                                <span class="text-muted">{{ $account->platform }}</span>
                            </h5>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <h5 class="">Currency: <br>
                                <span class="text-muted">{{ $account->currency }}</span>
                            </h5>
                            <h5 class="">Leverage: <br>
                                <span class="text-muted">{{ $account->leverage }}</span>
                            </h5>
                            <h5 class="">Server: <br>
                                <span class="text-muted">{{ $account->server }}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" x-data="{ showmetrics: true }" x-show="showmetrics">
            @include('purpose.copy-trade.metrics')
        </div>
    </div>
</div>
