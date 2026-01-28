@use('\Illuminate\Support\Number', 'Number')
<div>
    <h1 class="h2">
        Deposit into your account
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data="{ method: @entangle('method') }">
        <div class="col-12">
            <form wire:submit='submitPayment'>
                <div class="row">
                    @forelse ($methods as $method)
                        <div class="col-6 col-xl-3" wire:key="{{ $method->id }}">
                            <!-- Card -->
                            <a href="" @click.prevent="method = '{{ $method->name }}'">
                                <div class="card"
                                    x-bind:class="method == '{{ $method->name }}' ? 'border border-3 border-primary' : ''">
                                    <div class="card-body">
                                        <div class="d-lg-flex">
                                            <div class="mb-2 d-flex mb-lg-0">
                                                @if (empty($method->img_url))
                                                    <div>
                                                        <svg width="20" viewBox="0 0 1024 1024" class="icon"
                                                            version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M512 512m-480 0a480 480 0 1 0 960 0 480 480 0 1 0-960 0Z"
                                                                fill="#E9E8FF" />
                                                            <path
                                                                d="M467.2 332.8l230.4-83.2 44.8 83.2zM384 332.8l96-83.2 38.4 51.2-64 32z"
                                                                fill="#C6C9FF" />
                                                            <path
                                                                d="M300.8 755.2c-25.6 0-51.2-25.6-51.2-51.2V384c0-25.6 25.6-51.2 51.2-51.2h428.8c25.6 0 51.2 25.6 51.2 51.2v313.6c0 25.6-25.6 51.2-51.2 51.2l-428.8 6.4z"
                                                                fill="#8880FE" />
                                                            <path
                                                                d="M761.6 608H704c-25.6 0-51.2-19.2-51.2-51.2v-19.2c0-25.6 25.6-51.2 51.2-51.2h57.6c25.6 0 51.2 19.2 51.2 51.2v25.6c0 25.6-19.2 44.8-51.2 44.8z"
                                                                fill="#C6C9FF" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div> <img src="{{ $method->img_url }}" width="20"></div>
                                                @endif
                                            </div>
                                            &nbsp;&nbsp;
                                            <div>
                                                <!-- Title -->
                                                <h3 class="mb-0 card-title text-dark h4">{{ $method->name }}</h3>
                                                <small class="m-0 text-xs text-muted">Pay via
                                                    {{ $method->name }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="mb-1 text-center col-md-12">
                            <x-no-data />
                            <p>
                                No Payment Method enabled at the moment, please check
                                back later.
                            </p>
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="mt-2 col-lg-8">
                        <p class="mb-1">Quick amount</p>
                        <div class="row">
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 100)">
                                    <div class="py-1 text-center card fw-bold">
                                        {{ $settings->currency }} 100
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 200)">
                                    <div class="py-2 text-center card fw-bold">
                                        {{ $settings->currency }} 200
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 400)">
                                    <div class="py-2 text-center card fw-bold">
                                        {{ $settings->currency }} 400
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 500)">
                                    <div class="py-2 text-center card fw-bold">
                                        {{ $settings->currency }} 500
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 800)">
                                    <div class="py-2 text-center card fw-bold">
                                        {{ $settings->currency }} 800
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-3">
                                <a href="" wire:click.prevent="$set('amount', 1000)">
                                    <div class="py-2 text-center card fw-bold">
                                        {{ $settings->currency }} 1000
                                    </div>
                                </a>
                            </div>
                            <div class="mt-2 col-lg-12">
                                <label>or Enter amount</label>
                                <x-form.input placeholder="Enter Amount here" wire:model.live='amount'
                                    min="{{ $settings->minamt }}" type="number" name="amount" :required="true" />
                                @if (count($methods) > 0)
                                    <div class="mt-3 col-12">
                                        <x-ui.button>
                                            Proceed to Payment
                                            <x-spinner wire:loading wire:target='submitPayment' />
                                            <i class="bi bi-arrow-right-circle-fill" wire:loading.remove
                                                wire:target='submitPayment'></i>
                                        </x-ui.button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
