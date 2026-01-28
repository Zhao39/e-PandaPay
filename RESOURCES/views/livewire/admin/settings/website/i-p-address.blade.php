@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    Blacklist IP Address
</x-slot:title>
<div>
    <x-breadcrumbs title="Blacklist IP Address">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Blacklist IP Address</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        @if (!$add)
            <div class="col-12">
                <div class="mb-2 text-right col-12">
                    <a href="#" class="btn btn-primary" wire:click="$set('add', true)">
                        <i class="fas fa-plus-circle" wire:loading.remove wire:target="add"></i>
                        <x-spinner wire:loading wire:target="add" />
                        Add New
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($ips->count() == 0)
                            <div class="text-center">
                                <x-no-data />
                                <h4 class="font-weight-bold">No Data Found</h4>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">IP Address</th>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ips as $ip)
                                            <tr>
                                                <td>{{ $ip->address }}</td>
                                                <td>{{ $ip->description }}</td>
                                                <td>
                                                    <button class="m-1 btn btn-danger btn-sm"
                                                        wire:click="delete('{{ $ip->id }}')"
                                                        wire:confirm='Are you sure you want to delete this IP Address?'>
                                                        <i class="bi bi-trash" wire:loading.remove
                                                            wire:target="delete('{{ $ip->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $ip->id }}')" />
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $ips->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if ($add)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='save'>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Address</label>
                                    <x-form.input name="address" wire:model="address" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Description</label>
                                    <x-form.input name="description" wire:model="description" />
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                        <x-spinner wire:loading wire:target="save" />
                                        Save
                                    </x-ui.button>
                                    <x-ui.button type="button" class="btn-secondary" wire:click='cancel'>
                                        <x-spinner wire:loading wire:target="cancel" />
                                        Cancel
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
