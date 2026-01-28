@use('\Illuminate\Support\Number', 'Number')
<x-slot:title>
    Manage withdrawals
</x-slot:title>
<div>
    <x-breadcrumbs title="Manage Withdrawals">
        <li class="nav-item">
            <a href="#">Manage Withdrawals</a>
        </li>
    </x-breadcrumbs>
    @if (!$viewWithdrawal)
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
                                    'processed' => 'Processed',
                                    'pending' => 'Pending',
                                    'cancelled' => 'Cancelled',
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
                        @if ($withdrawals->count() > 0)
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
                                        <x-form.input type="search" class="rounded" placeholder="Search Withrdawals"
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
                                            <th>Amount + charges</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Date created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawals as $item)
                                            <tr>
                                                <td>
                                                    <a class=" text-underline text-info"
                                                        @if ($settings->spa_mode) wire:navigate @endif
                                                        href="{{ route('admin.users.singleUser', ['user' => $item->user]) }}">{{ $item->user->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ Number::currency($item->amount, $settings->s_currency) }}
                                                </td>
                                                <td>
                                                    {{ Number::currency($item->to_deduct, $settings->s_currency) }}
                                                </td>
                                                <td>{{ $item->payment_mode }}</td>
                                                <td>
                                                    @if ($item->status == 'processed')
                                                        <span
                                                            class="badge badge-success">{{ ucfirst($item->status) }}</span>
                                                    @elseif ($item->status == 'pending')
                                                        <span
                                                            class="badge badge-warning">{{ ucfirst($item->status) }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="d-none d-lg-block">
                                                        {{ $item->created_at->toDayDateTimeString() }}
                                                    </span>
                                                    <span class="d-block d-lg-none">
                                                        {{ $item->created_at->format('d M, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @can('process withdrawals')
                                                        <a href="#" wire:click.prevent="view({{ $item->id }})"
                                                            class="m-1 btn btn-info btn-sm">
                                                            <i class="fa fa-eye" wire:loading.remove
                                                                wire:target="view({{ $item->id }})"></i>
                                                            <x-spinner wire:loading
                                                                wire:target="view({{ $item->id }})"></x-spinner>
                                                            View
                                                        </a>
                                                    @endcan
                                                    @can('delete withdrawals')
                                                        <button wire:loading.attr="disabled"
                                                            wire:confirm="Are you sure you want to detete this withdrawal?"
                                                            wire:target="delete('{{ $item->id }}')"
                                                            wire:click="delete('{{ $item->id }}')"
                                                            class="m-1 btn btn-danger btn-sm">
                                                            <x-spinner wire:loading
                                                                wire:target="delete('{{ $item->id }}')" />
                                                            Delete
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $withdrawals->links() }}
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <x-no-data />
                                @if ($search != '' || $status != 'All' || ($fromDate != '' && $toDate != ''))
                                    <h5 class="font-weight-bolder text-info">No Result found</h5>
                                    <p>We couldn't find what you are looking for. Try again.</p>
                                    <button type="button" class="btn btn-primary" wire:click='resetFilter'>
                                        Try again
                                    </button>
                                @else
                                    <h5 class="font-weight-bolder text-info">No Data found</h5>
                                    <p>
                                        You do not have any withdrawal record. <br> When your users place a
                                        withdrawal request, it will appear here.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($viewWithdrawal)
        <livewire:admin.withdrawal.process-withdrawal :id="$id" />
    @endif
</div>
<x-slot:scripts>

</x-slot:scripts>
