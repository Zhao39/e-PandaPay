@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5">
        <h1 class="h2">
            Managed Accounts
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div @class([
            'col-lg-12' => $settings->use_copytrade,
            'col-lg-8' => !$settings->use_copytrade,
        ])>
            <div class="border-0 card">
                <div class="border-0 card-header">
                    <!-- Title -->
                    <h2 class="mb-0 h3">
                        Advanced {{ $settings->site_name }} Account manager
                    </h2>
                </div>

                <div class="card-body">
                    <h4 class="mb-3">Description</h4>

                    <p class="mb-3">
                        Don’t have time to trade or learn how to trade?</p>
                    <p>
                        Our Account Management Service is The Best Profitable Trading Option for you,
                        We can help you to manage your account in the financial MARKET with a simple
                        subscription model.
                    </p>
                    <small class=" fw-bold">
                        Terms and Conditions apply
                    </small>
                    <br>Reach us at
                    <span class=" fw-bold">
                        {{ $settings->contact_email }}
                    </span>
                    for more info.

                    <h4 class="my-3">Checklist</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist1" checked>
                                <label class="form-check-label" for="checklist1">
                                    Trade on your behalf
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist2" checked>
                                <label class="form-check-label" for="checklist2">
                                    Manage your account
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" checked>
                                <label class="form-check-label" for="checklist3">
                                    Withdraw your profit yourself
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" checked>
                                <label class="form-check-label" for="checklist3">
                                    24/7 Support
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Transparency
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" checked>
                                <label class="form-check-label" for="checklist3">
                                    You're 100% in Control
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Safe & Secure
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="border-0 card">
                <div class="card-body">
                    <div class="mb-3 d-lg-flex justify-content-between align-items-center">
                        <h4 class="mb-5">Accounts under management.</h4>
                        <div class="mt-3 mt-lg-0">
                            @if ($settings->use_copytrade)
                                <a href="{{ route('user.copier.masters') }}" class="btn btn-success btn-sm"
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
                                    <th>Start date</th>
                                    <th>End Date</th>
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
                                                    'bg-warning' => $account->status == 'pending',
                                                    'bg-danger' => $account->status == 'expired',
                                                    'bg-success' => $account->status == 'processed',
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
                                            </td>
                                            <td>
                                                @if (!empty($account->end_date))
                                                    {{ $account->end_date->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
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
            <div class="col-lg-4">
                <div class="border-0 card">
                    <div class="card-body">
                        <h4 class="mb-3">Add new account</h4>
                        <form wire:submit='addAccount'>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>Duration</label>
                                    <select class="mt-2 form-control" wire:model.live="duration">
                                        <option>Monthly</option>
                                        <option>Quarterly</option>
                                        <option>Yearly</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Amount({{ $settings->currency }})</label>
                                    <x-form.input class="mt-2" wire:model="amount" readOnly="true" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Platform</label>
                                    <select class="mt-2 form-control" wire:model="platform">
                                        <option>MT4</option>
                                        <option>MT5</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Login</label>
                                    <x-form.input class="mt-2" wire:model="login" name="login" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Account Password</label>
                                    <x-form.input class="mt-2" wire:model="password" name="password" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Account Name</label>
                                    <x-form.input class="mt-2" wire:model="name" name="name" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Account Type</label>
                                    <x-form.input class="mt-2" wire:model="account_type"
                                        placeholder="E.g. Standard" name="account_type" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Currency</label>
                                    <x-form.input class="mt-2" wire:model="currency" placeholder="E.g. USD"
                                        name="currency" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Leverage</label>
                                    <x-form.input class="mt-2" wire:model="leverage" placeholder="E.g. 1:500"
                                        name="leverage" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>Server</label>
                                    <x-form.input class="mt-2" wire:model="server"
                                        placeholder="E.g. HantecGlobal-live" name="server" required />
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
