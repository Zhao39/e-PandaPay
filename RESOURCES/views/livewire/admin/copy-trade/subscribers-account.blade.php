@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Subscribers Account
</x-slot:title>
<x-slot:styles>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</x-slot:styles>
<div x-data>
    <x-breadcrumbs title="Subscribers Account">
        <li class="nav-item">
            <a href="#">Subscribers Account</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    @if ($settings->use_copytrade)
        <div class="row">
            <div class="mb-2 col-lg-6 mb-lg-0">
                <button class="btn btn-primary btn-sm" wire:click="refreshSub" wire:loading.attr='disabled'
                    wire:target="refreshSub">
                    <x-spinner wire:loading wire:target="refreshSub" />
                    Refresh accounts
                </button>
            </div>
            <div class="text-right col-lg-6">
                <button class="btn btn-success btn-sm" wire:click="deploymentAll('subscribers', 'deploy')"
                    @disabled($accounts->count() == 0) wire:loading.attr='disabled'
                    wire:target="deploymentAll('subscribers', 'deploy')">
                    Deploy All
                </button>
                <button class="btn btn-danger btn-sm" wire:click="deploymentAll('subscribers', 'undeploy')"
                    wire:loading.attr='disabled' wire:target="deploymentAll('subscribers', 'undeploy')"
                    @disabled($accounts->count() == 0)>
                    Undeploy All
                </button>
            </div>
        </div>
    @endif
    <div @class(['mt-3 row row-cols-1 row-cols-lg-3'])>
        @if ($settings->use_copytrade)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if (!$addNewAccount)
                            <a href="#" wire:click.prevent="$set('addNewAccount', true)">
                                <div class="justify-content-center align-items-center d-none d-lg-flex"
                                    style="height: 474px; border-style: dashed;">
                                    <div class="text-center" wire:loading.remove wire:taget='addNewAccount'>
                                        <i class="bi bi-plus" style="font-size: 50px"></i>
                                        {{-- @if ($accounts->count() == 0)
                                            <h4 class="font-weight-bold">No Accounts Added</h4>
                                        @endif --}}
                                    </div>
                                    <x-spinner wire:loading wire:taget='addNewAccount' />
                                </div>
                                <div class="justify-content-center align-items-center d-flex d-lg-none"
                                    style="height: 100px; border-style: dashed;">
                                    <div class="text-center" wire:loading.remove wire:taget='addNewAccount'>
                                        <i class="bi bi-plus" style="font-size: 50px"></i>
                                        {{-- @if ($accounts->count() == 0)
                                            <h4 class="font-weight-bold">No Accounts Added</h4>
                                        @endif --}}
                                    </div>
                                    <x-spinner wire:loading wire:taget='addNewAccount' />
                                </div>
                            </a>
                        @endif
                        @if ($addNewAccount)
                            <livewire:admin.copy-trade.sub.add-account />
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @forelse ($accounts as $account)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if ($editAccount && $accountId == $account->id)
                            <livewire:admin.copy-trade.sub.edit-account :id="$accountId" :key="$account->id" />
                        @else
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="m-0 font-weight-bold">
                                        <i class="bi bi-person-circle"> </i>
                                        {{ $account->user_id ? $account->user->name : 'Guest Account' }}
                                    </h5>
                                    <small class="m-0"> <span class="font-weight-bold">Added At:</span>
                                        {{ $account->created_at->format('D d, M Y') }}
                                    </small>
                                    <x-spinner wire:loading />
                                </div>
                                <div>
                                    <span @class([
                                        'badge',
                                        'badge-danger' => $account->status == 'pending',
                                        'badge-success' => $account->status == 'processed',
                                    ])>{{ Str::ucfirst($account->status) }}</span>
                                    @if ($settings->use_copytrade)
                                        @if ($account->copying_trade)
                                            <i class="bi bi-circle-fill text-success" data-toggle="tooltip"
                                                data-placement="top" title="CopyTrade is On"></i>
                                        @else
                                            <i class="bi bi-circle-fill text-danger" data-toggle="tooltip"
                                                data-placement="top" title="CopyTrade is Off"></i>
                                        @endif
                                    @endif
                                </div>
                                <div class="dropdown">
                                    <a href="" class="text-dark" data-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"> </i>
                                    </a>

                                    <div class="dropdown-menu">
                                        @if ($settings->use_copytrade)
                                            @if ($account->status != 'pending')
                                                @if (Str::upper($account->deployment_status) == 'DEPLOYED')
                                                    <a class="dropdown-item" href="#"
                                                        wire:click.prevent="deployment('{{ $account->meta_account_id }}', 'Undeploy')">Undeploy</a>
                                                @else
                                                    <a class="dropdown-item" href="#"
                                                        wire:click.prevent="deployment('{{ $account->meta_account_id }}', 'Deploy')">Deploy</a>
                                                @endif
                                                @if (!$account->copying_trade)
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#copymodal"
                                                        wire:click="$set('accountId', '{{ $account->meta_account_id }}')"
                                                        href="#">Start Copying</a>
                                                @else
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#copymodal"
                                                        wire:click="setSync('{{ $account->meta_account_id }}', 
                                                        '{{ $account->provider }}')"
                                                        href="#">Sync Copying</a>
                                                @endif
                                            @endif
                                        @endif

                                        @if ($settings->use_copytrade && !$profile['use_my_metaapi_account'])
                                            @if (now()->greaterThanOrEqualTo($account->expired_at))
                                                @if (now()->greaterThanOrEqualTo($account->expired_at))
                                                    <a class="dropdown-item" href="#"
                                                        wire:confirm='You are about to renew this account'
                                                        wire:click.prevent="renew('{{ $account->meta_account_id }}')">Renew</a>
                                                @endif
                                            @endif
                                        @endif
                                        @if ($account->status == 'pending')
                                            <a class="dropdown-item" href="#"
                                                wire:click.prevent="setUpdate('{{ $account->id }}')">
                                                Edit
                                            </a>
                                        @endif

                                        <a class="dropdown-item text-danger"
                                            wire:click.prevent="deleteAccount('{{ $account->id }}')" href="#"
                                            wire:confirm='Are you sure you want to delete this subscriber account? This action is not reversible.'>Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="p-2 mb-2">
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-person"> </i>
                                            Name:
                                        </span>
                                        <span class="font-weight-bold">{{ $account->name }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-box-arrow-in-left"> </i>
                                            Login:
                                        </span>
                                        <span class=" font-weight-bold">{{ $account->login }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-key"> </i>
                                            Password:
                                        </span>
                                        <span class=" font-weight-bold">{{ $account->password }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-layers"> </i>
                                            Platform:
                                        </span>
                                        <span class="font-weight-bold">{{ Str::upper($account->platform) }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-hdd-stack"> </i>
                                            Server:
                                        </span>
                                        <span class="font-weight-bold">{{ $account->server }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-coin"> </i>
                                            Currency:
                                        </span>
                                        <span class="font-weight-bold">{{ $account->currency }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-water"> </i>
                                            Leverage:
                                        </span>
                                        <span class="font-weight-bold">{{ $account->leverage }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>
                                            <i class="bi bi-server"> </i>
                                            Copytrade Provider:
                                        </span>
                                        <span
                                            class="font-weight-bold">{{ !is_null($account->provider) ? $account->provider : '-' }}
                                        </span>
                                    </div>
                                    @if ($account->duration)
                                        <div class="mb-2 d-flex justify-content-between">
                                            <span>
                                                <i class="bi bi-calendar"> </i>
                                                Duration:
                                            </span>
                                            <span class=" font-weight-bold">{{ $account->duration }}</span>
                                        </div>
                                    @endif
                                    @if (!$settings->use_copytrade)
                                        <div>
                                            <small class="badge badge-light">
                                                <span class="font-weight-bold">Started
                                                    At:</span>
                                                {{ !is_null($account->start_date) ? $account->start_date->format('D d M, Y') : '-' }}
                                            </small>
                                            <small class="badge badge-light">
                                                <span class="font-weight-bold">Expired
                                                    At:</span>
                                                {{ !is_null($account->end_date) ? $account->end_date->format('D d M, Y') : '-' }}
                                            </small>
                                        </div>
                                    @else
                                        @if (!$profile['use_my_metaapi_account'])
                                            <small class="badge badge-light">
                                                <span class="font-weight-bold">Meta Api
                                                    Expiration:</span>
                                                {{ !is_null($account->expired_at) ? $account->expired_at->format('D d M, Y') : '-' }}
                                            </small>
                                        @endif
                                    @endif
                                    @if ($account->deployment_status)
                                        <small @class([
                                            'badge',
                                            'badge-success' => Str::upper($account->deployment_status) == 'DEPLOYED',
                                            'badge-warning' => Str::upper($account->deployment_status) == 'DRAFT',
                                            'badge-danger' => Str::upper($account->deployment_status) == 'UNDEPLOYED',
                                        ])>
                                            {{ Str::upper($account->deployment_status) }}
                                        </small>
                                    @endif
                                    @if ($account->status == 'pending')
                                        <div class="mt-2"">
                                            <x-ui.button type='button'
                                                wire:confirm='Are you sure you want to process this account?'
                                                wire:click="process('{{ $account->id }}')" class="btn-sm btn-block"
                                                wire:loading.attr='disabled'>
                                                <x-spinner wire:loading
                                                    wire:target="process('{{ $account->id }}')" />
                                                Process
                                            </x-ui.button>
                                        </div>
                                    @else
                                        @if ($settings->use_copytrade && empty($account->meta_account_id))
                                            <div class="mt-2"">
                                                <x-ui.button type='button'
                                                    wire:confirm='Are you sure you want to process this account?'
                                                    wire:click="process('{{ $account->id }}')"
                                                    class="btn-sm btn-block" wire:loading.attr='disabled'>
                                                    <x-spinner wire:loading
                                                        wire:target="process('{{ $account->id }}')" />
                                                    Create Sub Account
                                                </x-ui.button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="justify-content-center align-items-center d-none d-lg-flex"
                            style="height: 474px;">
                            <div class="text-center">
                                <x-no-data />
                                <h4 class="font-weight-bold">No Accounts Added.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <div wire:ignore class="modal fade" id="copymodal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" data-background-color="light">
                <div class="modal-content" data-background-color="light">
                    <div class="modal-header">
                        <h5 class="modal-title">Start Copy Trade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit='copyTrade'>
                            <div class="form-group">
                                @if ($masterId)
                                    <h4>
                                        Your copytrade provider is:
                                        <span class="font-weight-bold">{{ $masterId }}</span>
                                    </h4>
                                @else
                                    <label>Select Master account to copy from.</label>
                                    <select wire:model='masterId' class="form-control">
                                        <option value="null">Select provider..</option>
                                        @foreach ($providers as $item)
                                            <option value="{{ $item['id'] }}">
                                                {{ $item['account_name'] }}/{{ $item['login'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group">
                                <x-ui.button>
                                    Start Copy Trade
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end copy modal --}}
        <div class="mt-2 col-12">
            {{ $accounts->links() }}
        </div>
    </div>
