@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Copytrade" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Copytrade</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data="{ compact: true }">
        @if (!$settings->use_copytrade)
            <div class="mb-2 text-right col-12">
                <button x-text="compact ? 'Compact View' : 'Full View'" x-on:click="compact=!compact"
                    class="btn btn-primary btn-sm "></button>
            </div>
        @endif

        <div x-bind:class="compact ? 'col-lg-8' : 'col-lg-12'" @class([
            'col-lg-12' => $settings->use_copytrade,
            'col-lg-8' => $settings->use_copytrade,
        ])>
            <div class="border-0 card" x-show="compact">
                <div class="border-0 card-header">
                    <h3 class="mb-0 h3 font-weight-bold">
                        Advanced {{ $settings->site_name }} Account manager
                    </h3>
                </div>

                <div class="card-body">
                    <p class="mb-3">
                        Don’t have time to trade or learn how to trade?</p>
                    <p>
                        Our Account Management Service is The Best Profitable Trading Option for you,
                        We can help you to manage your account in the financial MARKET with a simple
                        accountscription model.
                    </p>
                    <small>
                        Terms and Conditions apply
                    </small>
                    <br>
                    Reach us at {{ $settings->contact_email }} for more info.
                </div>
            </div>

            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="mb-3 d-lg-flex justify-content-between align-items-center">
                        <h4>My Accounts</h4>
                        <div class="mt-3 mt-lg-0">
                            @if ($settings->use_copytrade)
                                <a href="{{ route('user.copier.masters') }}" class="btn btn-danger btn-sm"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <i class="bi bi-person-lines-fill"></i>
                                    View Providers
                                </a>
                            @endif
                            @if ($settings->ib_link)
                                <a href="{{ $settings->ib_link }}" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="bi bi-person-vcard-fill"></i>
                                    Create Account
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($accounts->count() === 0)
                        <div class="text-center">
                            <x-no-data />
                            <h6 class="h5">You have no managed accounts</h6>
                            <a href="{{ route('user.copier.masters') }}" class="btn btn-primary btn-sm"
                                @if ($settings->spa_mode) wire:navigate @endif>
                                <i class="bi bi-person-lines-fill"></i>
                                View Providers
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Account</th>
                                    <th>Currency</th>
                                    <th>Leverage</th>
                                    <th>Server</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Submitted at</th>
                                    <th>Start/End date</th>
                                    <th>Provider</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>
                                                {{ $account->login }} <br> {{ $account->account_type }}
                                            </td>
                                            <td>
                                                {{ $account->currency }}
                                            </td>
                                            <td>
                                                {{ $account->leverage }}
                                            </td>
                                            <td>
                                                {{ $account->server }}
                                            </td>
                                            <td>
                                                {{ $account->duration }}
                                            </td>
                                            <td>
                                                <span @class([
                                                    'badge',
                                                    'badge-warning' => $account->status == 'pending',
                                                    'badge-danger' => $account->status == 'expired',
                                                    'badge-success' => $account->status == 'processed',
                                                ])>
                                                    {{ Str::ucfirst($account->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $account->created_at->format('M d Y') }}
                                            </td>
                                            <td>
                                                @if (!empty($account->start_date))
                                                    {{ $account->start_date->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                                /
                                                @if (!empty($account->end_date))
                                                    {{ $account->end_date->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{ $account->provider }}
                                            </td>
                                            <td>
                                                @php
                                                    $endAt = $account->end_date;
                                                    $remindAt = $account->reminded_at;
                                                @endphp
                                                @if ($settings->use_copytrade && $account->status == 'pending')
                                                    <a href="{{ route('user.copier.account.info', ['account' => $account]) }}"
                                                        class="btn btn-info btn-sm"
                                                        @if ($settings->spa_mode) wire:navigate @endif>
                                                        <i class="bi bi-info-circle-fill"></i>
                                                        Info
                                                    </a>
                                                @endif
                                                @if (($account->status != 'pending' && now()->isSameDay($remindAt)) || $account->status == 'expired')
                                                    <button wire:loading.attr='disabled'
                                                        wire:confirm='Are you sure you want to renew this account'
                                                        wire:click.prevent="renew('{{ $account->id }}')"
                                                        class="btn btn-primary btn-sm">
                                                        <x-spinner wire:loading
                                                            wire:target="renew('{{ $account->id }}')" />
                                                        Renew
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (!$settings->use_copytrade)
            <div class="col-lg-4" x-show="compact">
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
                                    <x-form.input wire:model="account_type" placeholder="E.g. Standard"
                                        name="account_type" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Currency</label>
                                    <x-form.input wire:model="currency" placeholder="E.g. USD" name="currency"
                                        required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Leverage</label>
                                    <x-form.input wire:model="leverage" placeholder="E.g. 1:500" name="leverage"
                                        required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Server</label>
                                    <x-form.input wire:model="server" placeholder="E.g. HantecGlobal-live"
                                        name="server" required />
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
        @endif
    </div>
</div>
