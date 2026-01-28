@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    System Admins
</x-slot:title>
<div>
    <x-breadcrumbs title="Administrators">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>Platform
                Administration</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Administrators</a>
        </li>

    </x-breadcrumbs>
    @if (!$addNewMember && !$updateMember && !$resetPassword)
        <div class="row">
            @can('create admin')
                <div class="mb-4 text-right col-12">
                    <x-ui.button type="button" wire:click="$set('addNewMember', true)">
                        <x-spinner wire:loading wire:target="addNewMember" />
                        Add Admin
                    </x-ui.button>
                </div>
            @endcan
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Roles</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->admins as $admin)
                                        <tr wire:key="{{ $admin->id }}">
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone_number }}</td>
                                            <td>
                                                @forelse ($admin->roles as $role)
                                                    <span @class([
                                                        'badge',
                                                        'badge-light' => $role->name !== 'Super Admin',
                                                        'badge-secondary' => $role->name === 'Super Admin',
                                                    ])>{{ $role->name }}</span>
                                                @empty
                                                    <span class="badge badge-danger"> Not Assigned</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                {{ $admin->created_at->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                <span
                                                    @class([
                                                        'badge',
                                                        'badge-danger' => $admin->status->value !== 'active',
                                                        'badge-success' => $admin->status->value === 'active',
                                                    ])>{{ Str::ucfirst($admin->status->value) }}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                                                        role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </a>
                                                    <div class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                        @can('block and unblock admin')
                                                            @if ($admin->status->value === 'blocked')
                                                                <a class="m-1 btn btn-primary btn-sm" href=""
                                                                    wire:click.prevent="setStatus('{{ $admin->id }}', 'active')">Unblock</a>
                                                            @else
                                                                <a class="m-1 btn btn-danger btn-sm" href=""
                                                                    wire:click.prevent="setStatus('{{ $admin->id }}', 'blocked')">Block</a>
                                                            @endif
                                                        @endcan

                                                        @can('edit admin details')
                                                            <a href="#"
                                                                wire:click.prevent="setForUpdate('{{ $admin->id }}')"
                                                                class="m-1 btn btn-secondary btn-sm">
                                                                <x-spinner wire:loading
                                                                    wire:target="setForUpdate('{{ $admin->id }}')" />
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can('change admin password')
                                                            <a href="#" wire:click="setReset('{{ $admin->id }}')"
                                                                class="m-1 btn btn-warning btn-sm">
                                                                <x-spinner wire:loading
                                                                    wire:target="setReset('{{ $admin->id }}')" />
                                                                Reset Password
                                                            </a>
                                                        @endcan
                                                        @can('delete admin')
                                                            @if ($this->admins->count() !== 1)
                                                                <a href="#" data-toggle="modal"
                                                                    wire:click="setDelete('{{ $admin->id }}')"
                                                                    data-target="#deleteModal"
                                                                    class="m-1 btn btn-danger btn-sm">Delete</a>
                                                            @endif
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($addNewMember)
        @include('livewire.admin.platform-administration.administrators.include.add-account')
    @endif
    @if ($updateMember)
        @include('livewire.admin.platform-administration.administrators.include.edit-account')
    @endif
    @if ($resetPassword)
        @include('livewire.admin.platform-administration.administrators.reset-password')
    @endif
    <!-- Delete user Modal -->
    <div wire:ignore.self id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" data-background-color="light">
                <div class="modal-header ">
                    <h4 class="modal-title ">Delete Admin</strong></h4>
                    <button type="button" class="close " data-dismiss="modal">&times;</button>
                </div>
                <div class="p-3 modal-body">
                    <p class="">Are you sure you want to delete this admin account?
                    </p>
                    <x-ui.button data-dismiss="modal" type="button" class="btn-sm">
                        Cancel
                    </x-ui.button>
                    <x-ui.button data-dismiss="modal" type="button" class="btn-danger btn-sm"
                        wire:click='deleteAccount'>
                        Yes Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete user Modal -->
</div>
