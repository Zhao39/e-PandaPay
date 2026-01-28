@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5">
        <h1 class="h2">
            Provider account information
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data="{ sub: false }">
        <div x-bind:class="sub ? 'col-lg-8' : 'col-lg-12'">
            <div class="row">
                @if ($provider)
                    <div class="col-12">
                        <div class="mb-2 text-right">
                            <button class="btn btn-sm" x-bind:class="sub ? 'btn-danger' : 'btn-primary'"
                                x-on:click="sub = !sub">
                                <span x-text="sub ? 'Cancel' : ' Copy from this account'"></span>
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5 class="">Account: <br>
                                            <span class="text-muted">{{ $provider['account_name'] }}</span>
                                        </h5>
                                        <h5 class="">Account ID: <br>
                                            <span class="text-muted">{{ $provider['login'] }}</span>
                                        </h5>
                                        <h5 class="">Account Platform: <br>
                                            <span class="text-muted">{{ $provider['platform'] }}</span>
                                        </h5>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <h5 class="">Currency: <br>
                                            <span class="text-muted">{{ $provider['currency'] }}</span>
                                        </h5>
                                        <h5 class="">Leverage: <br>
                                            <span class="text-muted">{{ $provider['leverage'] }}</span>
                                        </h5>
                                        <h5 class="">Server: <br>
                                            <span class="text-muted">{{ $provider['server'] }}</span>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-3 font-weight-bold text-primary">Account Strategy</h5>
                                        <h6 class="font-weight-bold">
                                            Stategy Name:
                                        </h6>
                                        <p> {{ $provider['strategy_name'] }}</p>
                                        <h6 class="font-weight-bold">
                                            Description:
                                        </h6>
                                        <p>{{ $provider['strategy_description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($provider['show_stats'] === 1)
                        <div class="col-12">
                            <h5 class="font-weight-bold">Account Metrics</h5>
                        </div>
                        <div class="col-12">
                            <livewire:user.copy-trade.metrics :id="$provider['id']" lazy />
                        </div>
                    @endif
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="py-3 text-center card-body">
                                <h5 class=" font-weight-bold">No Data Available</h5>
                                <p class="card-text">We could not retrieve any data for this provider account</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div x-bind:class="sub ? 'col-lg-4' : 'd-none'">
            <div class="border-0 card">
                <div class="card-body">
                    <h4 class="mb-3">Add new account</h4>
                    <form wire:submit='addAccount'>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Duration</label>
                                <select class="form-control" wire:model.live="duration">
                                    <option>Monthly</option>
                                    <option>Quarterly</option>
                                    <option>Yearly</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Amount({{ $settings->currency }})</label>
                                <x-form.input wire:model="amount" readOnly="true" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Platform</label>
                                <select class="form-control" wire:model="platform">
                                    <option>MT4</option>
                                    <option>MT5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Login</label>
                                <x-form.input wire:model="login" name="login" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Account Password</label>
                                <x-form.input wire:model="password" name="password" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Account Name</label>
                                <x-form.input wire:model="name" name="name" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Account Type</label>
                                <x-form.input wire:model="account_type" placeholder="E.g. Standard" name="account_type"
                                    required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Currency</label>
                                <x-form.input wire:model="currency" placeholder="E.g. USD" name="currency" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Leverage</label>
                                <x-form.input wire:model="leverage" placeholder="E.g. 1:500" name="leverage" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Server</label>
                                <x-form.input wire:model="server" placeholder="E.g. HantecGlobal-live" name="server"
                                    required />
                            </div>
                            <h6>Amount will be deducted from your account balance.</h6>
                            <div class="col-md-12">
                                <x-ui.button>
                                    <x-spinner wire:loading wire:target='addAccount' />
                                    Add account
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
