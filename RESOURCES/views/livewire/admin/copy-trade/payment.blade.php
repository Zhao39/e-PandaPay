@use('\Illuminate\Support\Number', 'Number')
<div>
    @if ($myaccount)
        <div class="row" x-data>
            <div class="col-12">
                <a href="" wire:click.prevent='refreshProfile'>
                    <x-spinner wire:loading wire:target='refreshProfile' />
                    Refresh Profile
                </a>
            </div>
            <div class="col-lg-6">
                <div class="border shadow-none card shadow-0 card-stats card-light card-round border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="text-center icon-big text-primary">
                                    <i class="bi bi-app-indicator"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers d-lg-flex">
                                    <div>
                                        <p class="card-category">Trading Account Slot</p>
                                        <h4 class="card-title">
                                            {{ $myaccount['trading_account_slot'] ? $myaccount['trading_account_slot'] : '0' }}
                                        </h4>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div>
                                        <a href="" class="btn btn-sm btn-primary"
                                            x-on:click.prevent="$wire.setForBuy()">
                                            Buy Slot
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border shadow-none card shadow-0 card-stats card-light card-round border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="text-center icon-big text-primary">
                                    <i class="bi bi-wallet"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">

                                <div class="numbers d-lg-flex">
                                    <div>
                                        <p class="card-category">Wallet Balance</p>
                                        <h4 class="card-title">
                                            {{ Number::currency($myaccount['wallet_balance'], $settings->s_currency) }}
                                        </h4>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div>
                                        <a href="" x-on:click.prevent="$wire.setForFund()"
                                            class="btn btn-sm btn-primary">Topup</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($buy_slot)
                <div class="mt-3 col-12" wire:transition>
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold">Buy a Trading Slot</h4>
                        <div>
                            <a href="" @click.prevent="$wire.resetProps()">
                                <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form wire:submit='purchaseSlot'>
                                <div class="form-group">
                                    <label>Number of Slot</label>
                                    <x-form.input type="number" name="slot" @keyup="$wire.calculateSlot()"
                                        wire:model='slot' required />
                                </div>
                                <div class="form-group">
                                    <label>You will be charged ($)</label>
                                    <x-form.input type="number" name="amount" wire:model='amount' readonly />
                                    <small>Amount will be deducted from your wallet</small>
                                </div>
                                <div class="form-group">
                                    <x-ui.button>
                                        <x-spinner wire:loading wire:target="purchaseSlot" />
                                        Purcahse
                                    </x-ui.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if ($add_funds)
                <div class="mt-3 col-12">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold">Add Funds to your Wallet</h4>
                        <div>
                            <a href="" @click.prevent="$wire.resetProps()">
                                <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        @if (!$toPay)
                            <div class="col-md-8 offset-md-2">
                                <form wire:submit="$set('toPay', true)">
                                    <div class="form-group">
                                        <label>Enter Amount ($)</label>
                                        <x-form.input type="number" wire:model='fund_amount' name='fund_amount'
                                            required />
                                    </div>
                                    <div class="form-group">
                                        <div style="cursor:pointer;"
                                            class="py-1 text-center border rounded-lg shadow bg-light align-items-center border-primary">
                                            <img src="{{ asset('dash/tether-usdt-logo.png') }}" alt=""
                                                style="width: 25px;">
                                            <h5>Tether(USDT)</h5>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <x-ui.button>
                                            <x-spinner wire:loading wire:target="toPay" />
                                            Continue to Payment
                                        </x-ui.button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if ($toPay)
                            <div class="mt-3 col-md-8 offset-md-2">
                                <form wire:submit="completePayment">
                                    <div class="p-2 form-group bg-light">
                                        <p>
                                            Please send ${{ $fund_amount }} of {{ $set['currency_name'] }} to the
                                            wallet address below
                                        </p>
                                        <h2 class=" font-weight-bold">{{ $set['wallet_address'] }}</h2>
                                    </div>
                                    <div class="form-group">
                                        <x-ui.button>
                                            <x-spinner wire:loading wire:target="completePayment" />
                                            Complete Payment
                                        </x-ui.button>
                                        <x-ui.button wire:click="$set('toPay', false)" type="button"
                                            class="btn-secondary">
                                            <x-spinner wire:loading wire:target="toPay" />
                                            Cancel
                                        </x-ui.button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
