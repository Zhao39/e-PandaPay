@use('\Illuminate\Support\Number', 'Number')
<x-slot:title>
    Manage deposits
</x-slot:title>
<div>
    <x-breadcrumbs title="Manage Deposits">
        <li class="nav-item">
            <a href="#">Manage Deposits</a>
        </li>
    </x-breadcrumbs>
    @can('manually create deposit')
        <div class="mb-2 row">
            <div class=" col-12">
                <div class="text-right">
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addDepositModal">
                        <i class="fa fa-plus"></i>
                        Add Deposit
                    </a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addDepositModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add a Deposit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <livewire:admin.manage-deposits.add-deposit />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <div class="row" x-data="{ showfilters: false }">
        <div class="col-12">
            <div class="card" style="display: none" x-show="showfilters" x-transition.duration.500ms>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p>Filters</p>
                        <div>
                            <a href="" @click.prevent="showfilters = false">
                                <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-around">
                        <div class="mb-2">
                            <x-form.label label="Status" />
                            <x-form.select wire:model.live='status' :options="[
                                'All' => 'All',
                                'Processed' => 'Processed',
                                'Pending' => 'Pending',
                            ]" />
                        </div>

                        <div class="mb-2">
                            <x-form.label label="Record per Page" />
                            <x-form.select wire:model.live='perPage' :options="[
                                '10' => '10',
                                '20' => '20',
                                '50' => '50',
                            ]" />
                        </div>

                        <div class="mb-2">
                            <x-form.label label="Order" />
                            <x-form.select wire:model.live='order' :options="[
                                'desc' => 'Descending',
                                'asc' => 'Ascending',
                            ]" />
                        </div>

                        <div class="mb-2">
                            <x-form.label label="From" />
                            <x-form.input type="date" wire:model.live="fromDate" />
                        </div>
                        <div class="mb-2">
                            <x-form.label label="To" />
                            <x-form.input type="date" wire:model.live="toDate" />
                        </div>

                        @if ($fromDate != '' && $toDate != '')
                            <div class="mb-2">
                                <x-ui.button type="button" class="btn-sm" wire:click='resetFilter'>
                                    reset date
                                </x-ui.button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($deposits->count() > 0)
                        <div class="mb-3 d-lg-flex justify-content-between">
                            <div class="d-lg-flex">
                                <div class="d-flex">
                                    <div class="mb-1 mr-2">
                                        <button @click="showfilters = !showfilters" class="border btn btn-light"
                                            type="button">
                                            <i class="fas fa-filter"></i>
                                            Filters
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <x-form.input type="search" class="rounded" placeholder="Search Deposits"
                                        wire:model.live='search' />
                                </div>
                            </div>
                            <div>
                                <button class="border btn btn-light" type="button" wire:click="$refresh">
                                    <i class="fas fa-sync"></i>
                                    Reload record
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposits as $deposit)
                                        <tr>
                                            <td>
                                                <a class=" text-underline text-info"
                                                    @if ($settings->spa_mode) wire:navigate @endif
                                                    href="{{ route('admin.users.singleUser', ['user' => $deposit->user]) }}">{{ $deposit->user->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ Number::currency($deposit->amount, $settings->s_currency) }}
                                            </td>
                                            <td>{{ $deposit->payment_mode ? $deposit->payment_mode : '-' }}</td>
                                            <td>
                                                @if ($deposit->status == 'Processed')
                                                    <span class="badge badge-success">Proccessed</span>
                                                @else
                                                    <span class="badge badge-danger">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="d-none d-lg-block">
                                                    {{ $deposit->created_at->toDayDateTimeString() }}
                                                </span>
                                                <span class="d-block d-lg-none">
                                                    {{ $deposit->created_at->format('d M, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (!blank($deposit->proof))
                                                    @can('process deposits')
                                                        <a href="{{ asset('storage/' . $deposit->proof) }}" target="_blank"
                                                            class="m-1 btn btn-info btn-sm" title="View payment screenshot">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                @endif
                                                @can('delete deposits')
                                                    <button wire:click="delete('{{ $deposit->id }}')"
                                                        wire:loading.attr='disabled'
                                                        wire:confirm="Are you sure you want to delete this record?"
                                                        class="m-1 btn btn-danger btn-sm">
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $deposit->id }}')" />
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endcan

                                                @if ($deposit->status != 'Processed')
                                                    @can('process deposits')
                                                        <x-ui.button type="button" class="btn-sm"
                                                            wire:loading.attr="disabled"
                                                            wire:confirm="Are you sure you want to confirm this transaction?"
                                                            wire:click="confirmDeposit({{ $deposit->id }})">
                                                            <x-spinner wire:loading
                                                                wire:target="confirmDeposit({{ $deposit->id }})" />
                                                            Confirm
                                                        </x-ui.button>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $deposits->links() }}
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <img src="{{ asset('dash/images/cloud-database-svgrepo-com.svg') }}"
                                alt="no record found" class="img-fluid">

                            @if ($search != '' || $status != 'All' || ($fromDate != '' && $toDate != ''))
                                <h1 class="mt-3 font-weight-bolder text-info">No Result found</h1>
                                <p>We couldn't find what you are looking for. Try again.</p>
                                <button type="button" class="btn btn-primary" wire:click='resetFilter'>
                                    Try again
                                </button>
                            @else
                                <h1 class="mt-3 font-weight-bolder text-info">No Data found</h1>
                                <p>
                                    You do not have any deposit record. <br> When your users deposit into
                                    their
                                    account, it will appear here.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<x-slot:scripts>
    @script
        <script>
            $wire.on('close-deposit-modal', () => {
                $('#addDepositModal').modal('hide')
            });
        </script>
    @endscript
</x-slot:scripts>
