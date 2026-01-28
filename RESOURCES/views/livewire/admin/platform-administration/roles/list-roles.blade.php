<x-slot:title>
    Roles & Permissions
</x-slot:title>
<div x-data="{ addNewRole: @entangle('addNewRole').live, updateRole: @entangle('updateMode').live }">
    <x-breadcrumbs title="Roles & Permissions">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>Platform
                Administration</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Roles & Permissions</a>
        </li>
    </x-breadcrumbs>

    <div class="row">
        <div class="mb-3 text-right col-12" x-show="!addNewRole && !updateRole">
            <x-ui.button type="button" @click="addNewRole = true">
                <i class="fas fa-plus"></i>
                Add Role
            </x-ui.button>
        </div>

        <div class="col-lg-12" style="display: none" x-show="addNewRole" x-transition>
            @include('livewire.admin.platform-administration.roles.add-role')
        </div>
        <div class="col-12" x-show="!addNewRole">
            <div class="card">
                <div class="card-body">
                    @if ($updateMode)
                        <div>
                            @include('livewire.admin.platform-administration.roles.edit-role')
                        </div>
                    @endif
                    @if (!$updateMode)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr x-data="{ deleteMode: false }">
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $role->name }}
                                            </td>
                                            <td>
                                                {{ $role->created_at->inUserTimezone()->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                <div x-show="deleteMode" style="display: none">
                                                    <div class="mb-2">
                                                        <a href="" @click.prevent="deleteMode = false">
                                                            <span class="p-2 bg-light">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <x-ui.button type="button" class="btn-sm btn-danger"
                                                        wire:click="deleteRole('{{ $role->name }}')"
                                                        @click.prevent="deleteMode = false">
                                                        Confirm Delete
                                                    </x-ui.button>
                                                </div>

                                                <div x-show="!deleteMode">
                                                    @if ($role->name !== 'Super Admin' && $role->count() !== 1)
                                                        @if ($role->name !== 'User')
                                                            <x-ui.button type="button" class="m-1 btn-sm"
                                                                wire:click="setRole('{{ $role->name }}')">
                                                                <x-spinner wire:loading
                                                                    wire:target="setRole('{{ $role->name }}')" />
                                                                <i class="bi bi-pencil" wire:loading.remove
                                                                    wire:target="setRole('{{ $role->name }}')"></i>
                                                            </x-ui.button>
                                                            <x-ui.button type="button" class="m-1 btn-sm btn-danger"
                                                                @click="deleteMode = true">
                                                                <i class="fas fa-trash"></i>
                                                            </x-ui.button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <p class="text-center">No Data Available</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
