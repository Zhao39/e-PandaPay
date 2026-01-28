<x-slot:title>
    Payment Methods
</x-slot:title>
<div>
    <x-breadcrumbs title=" Payment Methods">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"> Payment Methods</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        @if (!$add_new && !$edit)
            @can('add payment method')
                <div class="mb-2 text-right col-12">
                    <a href="#" class="btn btn-primary" wire:click="$set('add_new', true)">
                        <i class="fas fa-plus-circle" wire:loading.remove wire:target="add_new"></i>
                        <x-spinner wire:loading wire:target="add_new" />
                        Add New Method
                    </a>
                </div>
            @endcan
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">
                            <strong>NOTE:</strong>
                            You can make use of automatic payment for your added crypto payment
                            methods. <strong>Only supported coins in Coinpayment.</strong> To view supported coins,
                            <a href="https://www.coinpayments.net/acct-coins" target="_blank">Click here</a>.
                            Strictly enter the symbol of the coin in the Symbol textbox provided. eg for Shiba Inu, use
                            SHIB, USD Coin, use USDC etc...
                        </p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Method Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Used for</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($methods as $method)
                                        <tr>
                                            <th>{{ $method->name }}</th>
                                            <td>
                                                {{ ucfirst($method->methodtype) }}
                                            </td>
                                            <td>
                                                @if ($method->type === 'both')
                                                    Deposit & Withdrawal
                                                @else
                                                    {{ ucfirst($method->type) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($method->status == 'active')
                                                    <span class=" badge badge-success">Enabled</span>
                                                @else
                                                    <span class=" badge badge-warning">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('edit payment method')
                                                    <a href="" wire:click.prevent="setUpdate('{{ $method->id }}')"
                                                        class="m-1 btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil" wire:loading.remove
                                                            wire:target="setUpdate('{{ $method->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="setUpdate('{{ $method->id }}')" />
                                                    </a>
                                                    @if ($method->status == 'active')
                                                        <button wire:click="changeStatus('{{ $method->id }}', 'inactive')"
                                                            class="m-1 btn btn-warning btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Mark as Disabled">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                        </button>
                                                    @else
                                                        <button wire:click="changeStatus('{{ $method->id }}', 'active')"
                                                            class="m-1 btn btn-success btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Mark as Active">
                                                            <i class="bi bi-check2-all"></i>
                                                        </button>
                                                    @endif
                                                @endcan
                                                @can('delete payment method')
                                                    <button class="m-1 btn btn-danger btn-sm"
                                                        wire:click="delete('{{ $method->id }}')"
                                                        wire:confirm='Are you sure you want to delete this payment method?'
                                                        @disabled($method->default_pay)>
                                                        <i class="bi bi-trash" wire:loading.remove
                                                            wire:target="delete('{{ $method->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $method->id }}')" />
                                                    </button>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $methods->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($add_new)
            @include('livewire.admin.settings.payment.add-payment')
        @endif
        @if ($edit)
            @include('livewire.admin.settings.payment.edit-payment')
        @endif
    </div>
</div>
