@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
@push('styles')
    <style>
        .text-xxs {
            font-size: 11px;
        }
    </style>
@endpush
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            Buy plan
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="mb-3 col-lg-8">
            <div class="card">
                <div class="py-5 card-body" x-data="{ open: false }">
                    <div class="form-group">
                        <label>Choose a plan</label>
                        <div class="border">
                            <div class="py-3 rounded-0 d-flex justify-content-between text-dark btn btn-outline-light align-items-center"
                                @click="open = ! open">
                                @if ($planSelected)
                                    <div>
                                        <x-spinner wire:loading wire:target="selectPlan" />
                                        <span class="font-weight-bold">
                                            {{ $planSelected->name }} -
                                            {{ Number::currency($planSelected->price, $settings->s_currency) }}
                                        </span>
                                        @if ($planSelected->status == 'inactive')
                                            <span class="badge badge-danger">
                                                {{ Str::ucfirst($planSelected->status) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <i class="bi" x-bind:class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                    </div>
                                @else
                                    <div>
                                        Choose plan
                                    </div>
                                    <div>
                                        <i class="bi" x-bind:class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                    </div>
                                @endif
                            </div>
                            <div x-show="open" class="mt-2" style="display: none;" @click.outside="open = false"
                                x-transition>
                                @foreach ($plans as $plan)
                                    <div class="gap-2 d-grid">
                                        <button class="border-0 text-start btn btn-outline-light text-dark rounded-0"
                                            @click="open=false" wire:click="selectPlan('{{ $plan->id }}')">
                                            {{ $plan->name }}
                                            @if ($plan->status == 'inactive')
                                                <span class="badge badge-danger">{{ $plan->status }}</span>
                                            @endif
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="my-4">
                        <label>Choose Quick Amount to Invest</label>
                        <div class="mt-3">
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount', '100')">{{ $settings->currency }}100</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','250')">{{ $settings->currency }}250</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','500')">{{ $settings->currency }}500</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','1000')">{{ $settings->currency }}1,000</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','1500')">{{ $settings->currency }}1,500</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','2000')">{{ $settings->currency }}2,000</button>
                            <button class="mb-3 rounded-none btn btn-primary"
                                wire:click="$set('amount','3000')">{{ $settings->currency }}3,000</button>
                        </div>
                    </div>

                    <div class="my-5">
                        <label>Or Enter Your Amount</label>
                        <div class="mt-2">
                            <x-form.input type="number" required wire:model.live='amount' placeholder="1000"
                                name="amount" min="{{ $planSelected ? $planSelected->min_price : '0' }}"
                                max="{{ $planSelected ? $planSelected->max_price : '10000000000' }}" />
                        </div>
                    </div>
                    <div class="mt-4 form-group">
                        <label>Payment Method</label>
                        <div class="p-3 mt-3 border rounded p-lg-4 d-lg-flex justify-content-between align-items-center border-primary"
                            style="cursor: pointer">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-wallet"></i>
                                &nbsp; &nbsp;
                                <span>Account Balance</span>
                            </div>
                            <div>
                                <span class="fs-3 font-weight-bold">
                                    {{ Number::currency(auth()->user()->account_bal, $settings->s_currency) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($planSelected)
            <div class="mb-2 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="font-weight-bold h4">Plan Details</p>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Name of plan</p>
                                <span
                                    class="text-md text-primary fs-3 fw-bold">{{ $planSelected ? $planSelected->name : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Plan Price</p>
                                <span class="text-primary text-md fs-3 fw-bold">
                                    {{ Number::currency($planSelected->price, $settings->s_currency) }}
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Duration</p>
                                <span class="text-primary text-md fs-3 fw-bold">
                                    {{ $planSelected ? $planSelected->duration : '-' }}
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">ROI</p>
                                <span class="text-primary text-md fs-3 fw-bold">
                                    @if ($planSelected)
                                        {{ $roiInfo }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Min Amount</p>
                                <span
                                    class="text-primary text-md fs-3 fw-bold">{{ $planSelected ? $settings->currency . $planSelected->min_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Max Amount</p>
                                <span
                                    class="text-primary text-md fs-3 fw-bold">{{ $planSelected ? $settings->currency . $planSelected->max_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Min Return</p>
                                <span
                                    class="text-primary text-md fs-3 fw-bold">{{ $planSelected ? $planSelected->min_return . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Max Return</p>
                                <span
                                    class="text-primary text-md fs-3 fw-bold">{{ $planSelected ? $planSelected->max_return . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small h6">Bonus</p>
                                <span
                                    class="text-primary text-md fs-3 fw-bold">{{ $planSelected ? $settings->currency . $planSelected->bonus : '-' }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="justify-content-between d-md-flex">
                            <span class="small d-block d-md-inline h6">Payment method:</span>
                            <span class="text-md text-primary">{{ $paymentMethod ? $paymentMethod : '-' }}</span>
                        </div>
                        <hr>
                        <div class="justify-content-between d-lg-flex align-items-center">
                            <span class="mb-0 d-block d-md-inline font-weight-bold h6">Amount to Invest:</span>
                            <span
                                class="mt-0 text-primary h2">{{ $settings->currency }}{{ $amount ? number_format($amount) : '0' }}</span>
                        </div>
                        <div class="mt-3 text-center">
                            <form wire:submit="joinPlan">
                                <button class="px-3 btn btn-primary" @disabled($disabled || ($planSelected && $planSelected->status !== 'active'))>
                                    <x-spinner wire:loading wire:target="joinPlan" />
                                    Confirm & Invest
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-4">
                <div class="card">
                    <div class="text-center card-body">
                        <h5 class="card-title">No Active Plans</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
