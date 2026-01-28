@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Manage crypto assets
</x-slot:title>
<div>
    <x-breadcrumbs title="Manage crypto assets">
        <li class="nav-item">
            <a href="#"> Manage crypto assets</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        @if (!$addNew && !$edit)
            <div class="col-12">
                <div class="mb-3 text-right">
                    <button type="button" class="btn btn-primary" wire:click="$set('addNew', true)">
                        <i class="fas fa-plus-circle" wire:loading.remove wire:target="addNew"></i>
                        <x-spinner wire:loading wire:target="addNew" />
                        Add Currency
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Currency</th>
                                        <th scope="col">Symbol</th>
                                        <th scope="col">Price To USD($)</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->symbol }}</td>
                                            <td class="text-left">
                                                <span> 1 {{ $item->symbol }} = ${{ $item->price_in_usd }}</span>
                                                @if ($item->is_default && $settings->use_api_price_for_swap)
                                                    <small style="font-size: 10px" class="d-block"> Price from
                                                        API</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge badge-success">Enabled </span>
                                                @else
                                                    <span class="badge badge-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="setEdit('{{ $item->id }}')"
                                                    class="m-1 btn btn-primary btn-sm" @disabled($item->is_default && $settings->use_api_price_for_swap)>
                                                    <i class="bi bi-pencil" wire:loading.remove
                                                        wire:target="setEdit('{{ $item->id }}')"></i>
                                                    <x-spinner wire:loading
                                                        wire:target="setEdit('{{ $item->id }}')" />
                                                </button>
                                                @if ($item->status == 'active')
                                                    <a href=""
                                                        wire:click.prevent="setStatus('{{ $item->id }}', 'inactive')"
                                                        class="m-1 btn btn-warning btn-sm">Disable</a>
                                                @else
                                                    <a href=""
                                                        wire:click.prevent="setStatus('{{ $item->id }}', 'active')"
                                                        class="m-1 btn btn-success btn-sm">Enable</a>
                                                @endif
                                                <button class="m-1 btn btn-danger btn-sm"
                                                    wire:click="delete('{{ $item->id }}')"
                                                    wire:confirm='Are you sure you want to delete this currency'
                                                    @disabled($item->is_default)>
                                                    <i class="bi bi-trash" wire:loading.remove
                                                        wire:target="delete('{{ $item->id }}')"></i>
                                                    <x-spinner wire:loading
                                                        wire:target="delete('{{ $item->id }}')" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $currencies->links() }}
                        </div>
                        <div>
                            <small>
                                Be sure your users do not have money in thier accounts before you disable or delete the
                                currency.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($addNew)
            @include('livewire.admin.crypto-swap.add')
        @endif
        @if ($edit)
            @include('livewire.admin.crypto-swap.edit')
        @endif
    </div>
</div>
