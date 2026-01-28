@use('\Illuminate\Support\Number', 'Number')
<div>
    <x-breadcrumbs title="Make a Deposit" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Deposit</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12" x-data="{ method: @entangle('method') }">
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-8">
                            <form wire:submit='submitPayment'>
                                <div class="form-row">
                                    <div class="mb-3 form-group col-md-12">
                                        <label>Enter Amount</label>
                                        <x-form.input placeholder="Enter Amount here" wire:model='amount'
                                            min="{{ $settings->minamt }}" type="number" name="amount"
                                            :required="true" />
                                    </div>
                                    <div class="mt-2 mb-1 col-lg-12">
                                        <h5 class="font-weight-bold">
                                            Choose your method of payment from the list below
                                        </h5>
                                    </div>
                                    @forelse ($methods as $method)
                                        <div class="mb-2 col-lg-6">
                                            <a href="" class="text-decoration-none"
                                                @click.prevent="method = '{{ $method->name }}'">
                                                <div class="border rounded"
                                                    x-bind:class="method == '{{ $method->name }}' ? 'border-primary' : ''">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <span class="">
                                                            @if (!empty($method->img_url))
                                                                <img src="{{ $method->img_url }}" alt=""
                                                                    class="" style="width: 25px;">
                                                            @endif
                                                            {{ $method->name }}
                                                        </span>
                                                        <span>
                                                            <input type="radio"
                                                                x-bind:checked="method == '{{ $method->name }}'">
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="mb-1 col-md-12">
                                            <p class="">No Payment Method enabled at the moment, please check
                                                back later.</p>
                                        </div>
                                    @endforelse
                                    @if (count($methods) > 0)
                                        <div class="mt-2 mb-1 col-md-12">
                                            <x-ui.button>
                                                Procced to Payment
                                                <x-spinner wire:loading wire:target='submitPayment' />
                                                <i class="bi bi-arrow-right-circle-fill" wire:loading.remove
                                                    wire:target='submitPayment'></i>
                                            </x-ui.button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="mt-4 mb-3 col-md-4 mt-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-0">Total Deposited</h6>
                                    <h3 class="mb-1 font-weight-bold">
                                        {{ Number::currency(auth()->user()->totalDeposits(), $settings->s_currency) }}
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="actions">
                                        <a href="" class="action-item">
                                            <span class="btn-inner--icon">View deposit history</span>
                                        </a>
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
