@use('\Illuminate\Support\Number', 'Number')
<div>
    <x-breadcrumbs title="Make payment" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="{{ route('user.deposit.make') }}" @if ($settings->spa_mode) wire:navigate @endif>Deposit</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Make Payment</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="mb-2 text-right col-12">
            <a href="{{ route('user.deposit.make') }}" class="btn btn-warning btn-sm"
                @if ($settings->spa_mode) wire:navigate @endif>
                <i class="bi bi-x"></i>
                Cancel payment
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <img src="{{ $method->img_url }}" width="38">
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div>
                                <h4 class="mb-0 text-dark font-weight-bold">
                                    {{ $method->name }}
                                </h4>
                                <span class="m-0 text-muted">Pay via {{ strtolower($method->name) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class=" font-weight-bold">
                                {{ Number::currency($amount, $settings->s_currency) }}
                            </h2>
                        </div>
                    </div>
                    <!-- Title -->
                </div>
                @if ($method->methodtype == 'crypto')
                    @include('millage.deposit.includes.crypto-payment')
                @endif
                @if ($method->methodtype == 'currency')
                    @include('millage.deposit.includes.currency-payment')
                @endif
            </div>
        </div>
    </div>
</div>
