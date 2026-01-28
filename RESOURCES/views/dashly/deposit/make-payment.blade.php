@use('\Illuminate\Support\Number', 'Number')
<div>
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h2">
                Make payment
            </h1>
            <div>
                <a href="{{ route('user.deposit.make') }}" class="btn btn-danger btn-sm"
                    @if ($settings->spa_mode) wire:navigate @endif>
                    <i class="bi bi-x"></i>
                    Cancel payment
                </a>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
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
                    @include('dashly.deposit.includes.crypto-payment')
                @endif
                @if ($method->methodtype == 'currency')
                    @include('dashly.deposit.includes.currency-payment')
                @endif
            </div>
        </div>
    </div>
</div>
