@use('\Illuminate\Support\Arr', 'Arr')
@use('\Illuminate\Support\Number', 'Number')
<div>
    <x-breadcrumbs title="Account Information({{ $account->login }})" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="{{ route('user.copier.show') }}" @if ($settings->spa_mode) wire:navigate @endif>Copytrade
                overview</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Account Information</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="">Account:
                                <span class="font-weight-bold">{{ $account->name }}</span>
                            </h5>
                            <h5 class="">Account ID:
                                <span class="font-weight-bold">{{ $account->login }}</span>
                            </h5>
                            <h5 class="">Account Platform:
                                <span class="font-weight-bold">{{ $account->platform }}</span>
                            </h5>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <h5 class="">Currency:
                                <span class="font-weight-bold">{{ $account->currency }}</span>
                            </h5>
                            <h5 class="">Leverage:
                                <span class="font-weight-bold">{{ $account->leverage }}</span>
                            </h5>
                            <h5 class="">Server:
                                <span class="font-weight-bold">{{ $account->server }}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" x-data="{ showmetrics: true }" x-show="showmetrics">
            @include('millage.copy-trade.metrics')
        </div>
    </div>
</div>
