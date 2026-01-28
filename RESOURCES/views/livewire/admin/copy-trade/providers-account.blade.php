@use('\Carbon\Carbon', 'Carbon')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Providers
</x-slot:title>
<div>
    <x-breadcrumbs title="Provider Accounts">
        <li class="nav-item">
            <a href="#">Provider Accounts</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="text-right col-12 d-flex justify-content-between">
            <div>
                <a href="" wire:click.prevent='refreshProfile'>
                    <x-spinner wire:loading wire:target='refreshProfile' />
                    Refresh Data
                </a>
            </div>
            <div>
                <button class="btn btn-success btn-sm" wire:click="deploymentAll('providers', 'deploy')"
                    @disabled(empty($providers)) wire:loading.attr='disabled'
                    wire:target="deploymentAll('providers', 'deploy')">
                    Deploy All
                </button>
                <button class="btn btn-danger btn-sm" wire:click="deploymentAll('providers', 'undeploy')"
                    wire:loading.attr='disabled' wire:target="deploymentAll('providers', 'undeploy')"
                    @disabled(empty($providers))>
                    Undeploy All
                </button>
            </div>
        </div>
    </div>
    <div class="mt-3 row row-cols-1 row-cols-lg-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if (!$addNewAccount)
                        <a href="#" wire:click.prevent="$set('addNewAccount', true)">
                            <div class="justify-content-center align-items-center d-none d-lg-flex"
                                style="height: 394px; border-style: dashed;">
                                <div class="text-center" wire:loading.remove wire:taget='addNewAccount'>
                                    <i class="bi bi-plus" style="font-size: 50px"></i>
                                    @if (collect($providers)->count() == 0)
                                        <h4 class="font-weight-bold">No Accounts Added</h4>
                                    @endif
                                </div>
                                <x-spinner wire:loading wire:taget='addNewAccount' />
                            </div>
                            <div class="justify-content-center align-items-center d-flex d-lg-none"
                                style="height: 100px; border-style: dashed;">
                                <div class="text-center" wire:loading.remove wire:taget='addNewAccount'>
                                    <i class="bi bi-plus" style="font-size: 50px"></i>
                                    @if (collect($providers)->count() == 0)
                                        <h4 class="font-weight-bold">No Accounts Added</h4>
                                    @endif
                                </div>
                                <x-spinner wire:loading wire:taget='addNewAccount' />
                            </div>
                        </a>
                    @endif
                    @if ($addNewAccount)
                        <livewire:admin.copy-trade.prov.add-account />
                    @endif
                </div>
            </div>
        </div>
        @foreach ($providers as $provider)
            <div class="col">
                <div class="card">
                    @if ($update_strategy && $provider['id'] == $accountId)
                        <div class="card-body">
                            <div style="height: 395px; overflow-y:auto">
                                <livewire:admin.copy-trade.prov.update-strategy :id="$accountId" :key="$provider['id']" />
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span @class([
                                        'badge',
                                        'badge-success' =>
                                            Str::upper($provider['deployment_status']) === 'DEPLOYED',
                                        'badge-danger' =>
                                            Str::upper($provider['deployment_status']) === 'UNDEPLOYED',
                                    ])>{{ $provider['deployment_status'] }}</span>
                                    <x-spinner wire:loading />
                                </div>

                                <div class="dropdown">
                                    <a href="" class="text-dark" data-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"> </i>
                                    </a>
                                    <div class="dropdown-menu">
                                        @if (!$profile['use_my_metaapi_account'])
                                            @if (now()->greaterThanOrEqualTo(Carbon::parse($provider['end_date'])))
                                                <a class="dropdown-item" href="#"
                                                    wire:confirm='You are about to renew this account'
                                                    wire:click.prevent="renew('{{ $provider['id'] }}')">Renew</a>
                                            @endif
                                        @endif
                                        <a class="dropdown-item" href="#"
                                            wire:click.prevent="setForUpdate('{{ $provider['id'] }}')">Update
                                            Strategy</a>
                                        <a class="dropdown-item text-danger"
                                            wire:click.prevent="deleteAccount('{{ $provider['id'] }}')" href="#"
                                            wire:confirm='Are you sure you want to delete this provider account? This action is not reversible.'>Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-person"> </i>
                                        Name:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['account_name'] }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-box-arrow-in-left"> </i>
                                        Login:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['login'] }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-key"> </i>
                                        Password:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['password'] }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-layers"> </i>
                                        Platform:
                                    </span>
                                    <span class=" font-weight-bold">{{ Str::upper($provider['platform'] ?? '') }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-hdd-stack"> </i>
                                        Server:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['server'] }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-coin"> </i>
                                        Currency:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['currency'] }}</span>
                                </div>
                                <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                    <span>
                                        <i class="bi bi-water"> </i>
                                        Leverage:
                                    </span>
                                    <span class=" font-weight-bold">{{ $provider['leverage'] }}</span>
                                </div>
                            </div>
                            @if (!$profile['use_my_metaapi_account'])
                                <div>
                                    <small class="badge badge-light">
                                        <span class="font-weight-bold">Started At:</span>
                                        {{ Carbon::parse($provider['start_date'])->inUserTimezone()->toDayDateTimeString() }}
                                    </small>
                                    <small @class([
                                        'badge',
                                        'badge-light' => now()->lessThan(Carbon::parse($provider['end_date'])),
                                        'badge-danger' => now()->greaterThanOrEqualTo(
                                            Carbon::parse($provider['end_date'])),
                                    ])>
                                        <span class="font-weight-bold">Expired At:</span>
                                        {{ Carbon::parse($provider['end_date'])->inUserTimezone()->toDayDateTimeString() }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
