@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    System Users
</x-slot:title>
<div>
    <x-breadcrumbs title="Manage Users">
        <li class="nav-item">
            <a href="#">Users List</a>
        </li>
    </x-breadcrumbs>

    @session('errors')
        <div class="row">
            <div class="col-12">
                @foreach ($value as $failures)
                    <div class="alert alert-danger" role="alert">
                        @foreach ($failures as $error)
                            <strong> {{ $error }}</strong>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endsession

    <div class="row" x-data="{ showfilters: false }">
        <div class="col-12">
            @include('livewire.admin.manage-users.includes.filters')
        </div>
        @can('create user')
            <div class="mb-2 col-12" x-show="!showfilters">
                <div class="text-right">
                    <a href="{{ route('admin.users.add') }}" class="btn btn-primary"
                        @if ($settings->spa_mode) wire:navigate @endif>
                        <i class="fa fa-plus"></i>
                        Add User
                    </a>
                </div>
            </div>
        @endcan
        <div class="col-md-12">
            <div class="card" x-data="{
                bulkAction: @entangle('bulkAction').live
            }">
                <div class="card-header d-lg-flex justify-content-between">
                    <div class="mb-2 d-flex">
                        @if (!empty($checkedrecord))
                            <div class="dropdown">
                                <button class="border btn btn-light dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Bulk Actions
                                </button>
                                <div class="dropdown-menu">
                                    @can('perform bulk actions')
                                        <a class="dropdown-item" href="#"
                                            @click.prevent="bulkAction = 'adjust'">Adjust Account</a>
                                        <a class="dropdown-item" href="#" @click.prevent="bulkAction = 'clear'">Clear
                                            Account</a>
                                    @endcan
                                    @can('perform bulk actions')
                                        <a class="dropdown-item text-danger" href="#"
                                            @click.prevent="bulkAction = 'delete'">Delete Account</a>
                                    @endcan
                                </div>
                            </div>
                            @can('perform bulk actions')
                                <div class="ml-2">
                                    <button class="border btn btn-light" type="button" wire:click='startExport'>
                                        <i class="fas fa-file-excel"></i>
                                        Export
                                    </button>
                                </div>
                            @endcan
                        @endif
                        <div class="ml-2">
                            <button @click="showfilters = !showfilters" class="border btn btn-light" type="button">
                                <i class="fas fa-filter"></i>
                                Filters
                            </button>
                        </div>
                        @if (empty($checkedrecord))
                            <div class="ml-2" style="cursor: pointer">
                                <div class="border file-div btn btn-light" style="cursor: pointer">
                                    <span>Import <span class="" style="font-size: 10px">.xlsx</span></span>
                                    <input type="file" name="excelFile" wire:model='excelFile' class="file-input" />
                                </div>
                                <div>
                                    @error('excelFile')
                                        <small class="text-danger" style="font-size: 12px">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if ($excelFile)
                            <div class="ml-2">
                                <x-ui.button type='button' wire:click='saveImport' class="btn-sm"
                                    wire:loading.attr='disabled'>
                                    <x-spinner wire:loading wire:target='saveImport' />
                                    Save
                                </x-ui.button>
                            </div>
                        @endif
                    </div>
                    <div class="d-lg-flex">
                        <div>
                            <input wire:model.live='searchvalue' class="border form-control" type="search"
                                placeholder="Name, Username, Email" />
                        </div>
                        &nbsp;&nbsp;
                        <div>
                            <a class="border btn btn-light" wire:click="$refresh">
                                <i class="fas fa-sync"></i>
                                Reload record
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" x-show="bulkAction == ''">
                    @if (!empty($checkedrecord))
                        <div class="d-flex">
                            <p class="mr-3">
                                {{ count($checkedrecord) }}
                                {{ count($checkedrecord) === 1 ? 'Record' : 'Records' }} Selected
                            </p>
                            @if (count($checkedrecord) !== $numberOfUsers)
                                <a href="" wire:click.prevent='selectAllRecords' class="text-success">Select
                                    all
                                    {{ $numberOfUsers }} records in
                                    DB
                                </a>
                            @else
                                <a href="" wire:click.prevent='deSelectAll' class="text-danger">
                                    Deselect All
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="white-space-nowrap">
                                        @can('perform bulk actions')
                                            <div class="d-flex">
                                                <x-spinner wire:loading wire:target='selectAllRecords' />
                                                <x-spinner wire:loading wire:target='deSelectAll' />
                                                <x-spinner wire:loading wire:target='selectPage' />
                                                <x-spinner wire:loading wire:target='checkedrecord' />
                                                <input type="checkbox" wire:model.live='selectPage' />
                                            </div>
                                        @endcan
                                    </th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Account Balance</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->users as $user)
                                    <tr wire:key="{{ $user->id }}">
                                        <td class="align-middle">
                                            @can('perform bulk actions')
                                                <input type="checkbox" wire:model.live='checkedrecord'
                                                    value="{{ $user->id }}" />
                                            @endcan
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                                        alt="" srcset="" class="rounded-circle"
                                                        width="27">
                                                </div>
                                                &nbsp;
                                                <div class="text-left">
                                                    <a class=''
                                                        @if ($settings->spa_mode) wire:navigate @endif
                                                        href="{{ route('admin.users.singleUser', ['user' => $user]) }}">
                                                        {{ Str::limit($user->name, 20, '...') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{ Number::currency($user->account_bal, $settings->s_currency) }}
                                        </td>
                                        <td>{{ $user->country }}</td>
                                        <td>
                                            <span
                                                @class([
                                                    'badge',
                                                    'badge-success' => $user->status->value === 'active',
                                                    'badge-danger' => $user->status->value !== 'active',
                                                ])>{{ Str::ucfirst($user->status->value) }}</span>
                                        </td>
                                        <td>
                                            <span class="d-none d-lg-block">
                                                {{ $user->created_at->toDayDateTimeString() }}
                                            </span>
                                            <span class="d-block d-lg-none">
                                                {{ $user->created_at->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @can('edit user')
                                                <a class='btn btn-secondary btn-sm'
                                                    @if ($settings->spa_mode) wire:navigate @endif
                                                    href="{{ route('admin.users.singleUser', ['user' => $user]) }}">
                                                    View
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="pt-3 text-center">
                                            No Data Available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer" x-show="bulkAction == ''">
                    <div class="row">
                        <div class="col-12">
                            {!! $this->users->links() !!}
                        </div>
                    </div>
                </div>
                <div class="card-body" x-show="bulkAction != ''" style="display: none">
                    @include('livewire.admin.manage-users.includes.bulk-actions')
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" wire:submit='export'>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-lg-12">
                                <x-form.label label='Export As' />
                                <x-form.select name='exportAs' wire:model='exportAs' :options="[
                                    'Excel' => 'Excel',
                                    'CSV' => 'CSV',
                                ]" required />
                            </div>
                            <div class="mb-3 col-lg-12">
                                <x-form.label label='Select Fields to export' />
                                <x-form.select name='exportFields' wire:model='exportFields' :options="[
                                    'id' => 'ID',
                                    'username' => 'Username',
                                    'name' => 'Fullname',
                                    'email' => 'Email Address',
                                    'date_of_birth' => 'Date of Birth',
                                    'address' => 'Address',
                                    'country' => 'Country',
                                    'phone_number' => 'Phone Number',
                                    'account_bal' => 'Account Balance',
                                    'roi' => 'Profit Column',
                                    'bonus' => 'Bonus Column',
                                    'ref_bonus' => 'Referral Bonus',
                                    'created_at' => 'Registration Date',
                                ]"
                                    required multiple />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<x-slot:scripts>
    @script
        <script>
            $wire.on('open-export-modal', () => {
                $('#exportModal').modal('show')
            });
            $wire.on('close-export-modal', () => {
                $('#exportModal').modal('hide')
            });
        </script>
    @endscript
</x-slot:scripts>
