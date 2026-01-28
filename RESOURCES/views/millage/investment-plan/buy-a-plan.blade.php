@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Buy investment plan" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Buy plan</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="mb-3 col-lg-8">
            <div class="card">
                <div class="card-body" x-data="{ open: false }">
                    <div class="form-group">
                        <label>Choose a plan</label>
                        <div class="border shadow-sm">
                            <div class="d-flex justify-content-between btn btn-light align-items-center rounded-0"
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
                                    <button class="text-left btn btn-light btn-block rounded-0" @click="open=false"
                                        wire:click="selectPlan('{{ $plan->id }}')">
                                        {{ $plan->name }}
                                        @if ($plan->status == 'inactive')
                                            <span class="badge badge-danger">{{ $plan->status }}</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="mt-4 form-group">
                        <label>Choose Quick Amount to Invest</label>
                        <div>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount', '100')">{{ $settings->currency }}100</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','250')">{{ $settings->currency }}250</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','500')">{{ $settings->currency }}500</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','1000')">{{ $settings->currency }}1,000</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','1500')">{{ $settings->currency }}1,500</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','2000')">{{ $settings->currency }}2,000</button>
                            <button class="mb-2 border border-black rounded-none btn btn-light"
                                wire:click="$set('amount','3000')">{{ $settings->currency }}3,000</button>
                        </div>
                    </div>

                    <div class="mt-4 form-group">
                        <label>Or Enter Your Amount</label>
                        <div>
                            <x-form.input type="number" required wire:model.live='amount' placeholder="1000"
                                name="amount" min="{{ $planSelected ? $planSelected->min_price : '0' }}"
                                max="{{ $planSelected ? $planSelected->max_price : '10000000000' }}" />
                        </div>
                    </div>
                    <div class="mt-4 form-group">
                        <label>Payment Method</label>
                        <div>
                            <span class="d-block">Account Balance </span>
                            <h4 class="font-weight-bold">
                                {{ Number::currency(auth()->user()->account_bal, $settings->s_currency) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($planSelected)
            <div class="mb-2 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class=" font-weight-bold">Plan Details</p>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Name of plan</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $planSelected->name : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Plan Price</p>
                                <span class="text-primary small font-weight-bold" style="font-size: 17px">
                                    {{ Number::currency($planSelected->price, $settings->s_currency) }}
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Duration</p>
                                <span class="text-primary small font-weight-bold" style="font-size: 17px">
                                    {{ $planSelected ? $planSelected->duration : '-' }}
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">ROI</p>
                                <span class="text-primary small font-weight-bold" style="font-size: 17px">
                                    @if ($planSelected)
                                        {{ $roiInfo }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Minimum Amount</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $settings->currency . $planSelected->min_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Maximum Amount</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $settings->currency . $planSelected->max_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Minimum Return</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $planSelected->min_return . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Maximum Return</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $planSelected->max_return . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">Bonus</p>
                                <span class="text-primary small font-weight-bold"
                                    style="font-size: 17px">{{ $planSelected ? $settings->currency . $planSelected->bonus : '-' }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="justify-content-between d-md-flex">
                            <span class="small d-block d-md-inline">Payment method:</span>
                            <span class="small text-primary font-weight-bold"
                                style="font-size: 15px">{{ $paymentMethod ? $paymentMethod : '-' }}</span>
                        </div>
                        <hr>
                        <div class="justify-content-between d-md-flex">
                            <span class="d-block d-md-inline font-weight-bold">Amount to Invest:</span>
                            <span
                                class="text-primary font-weight-bold">{{ $settings->currency }}{{ $amount ? number_format($amount) : '0' }}</span>
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
