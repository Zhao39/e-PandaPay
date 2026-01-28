<x-slot:title>
    Symbol Maps
</x-slot:title>
<div>
    <x-breadcrumbs title="Symbol Maps">
        <li class="nav-item">
            <a href="#">Symbol Maps</a>
        </li>
    </x-breadcrumbs>
    <div class="row" x-data="{ new_symbol: @entangle('addSymbol') }">
        <div class="mb-2 text-right col-12" x-show="!new_symbol">
            <x-ui.button type='button' @click="new_symbol = true">
                New Symbol
            </x-ui.button>
        </div>
        <div class="col-lg-12" style="display: none" x-show="new_symbol" x-transition>
            <div class="card">
                <div class="row">
                    <div class="py-4 col-lg-6 offset-lg-3">
                        <h4>Add New Symbol map</h4>
                        <form action="" wire:submit='addSymbolMapping'>
                            <div class="form-group">
                                <label>Map Symbol From</label>
                                <x-form.input placeholder="eg EURUSD.m" wire:model='from' />
                            </div>
                            <div class="form-group">
                                <label>Map Symbol To</label>
                                <x-form.input placeholder="eg EURUSD" wire:model='to' />
                            </div>
                            <div class="form-group">
                                <x-ui.button type='button' class="btn-info" @click="new_symbol = false">
                                    Cancel
                                </x-ui.button>
                                <x-ui.button>
                                    <x-spinner wire:loading wire:target='addSymbolMapping' />
                                    Add Symbol
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" x-show="!new_symbol">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Symbol From</th>
                            <th>Symbol To</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @forelse ($symbols as $symbol)
                                <tr>
                                    <td>{{ $symbol->from_symbol }}</td>
                                    <td>{{ $symbol->to_symbol }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm"
                                            wire:confirm='Are you sure you want to delete this symbol map'
                                            wire:click="deleteSymbolMapping({{ $symbol->id }})">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <x-no-data />
                                        <h4 class=" font-weight-bold"> No symbols maps defined</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
