@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Users Transactions
</x-slot:title>
<div>
    <x-breadcrumbs title="Transactions">
        <li class="nav-item">
            <a href="#">Transactions</a>
        </li>
    </x-breadcrumbs>
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
                                'all' => 'All',
                                'completed' => 'Completed',
                                'pending' => 'Pending',
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
                                <x-form.input type="search" class="rounded" placeholder="Search by User name"
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Transaction Type</th>
                                    <th>Narration</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $tra)
                                    <tr>
                                        <td>
                                            <a @if ($settings->spa_mode) wire:navigate @endif
                                                href="{{ route('admin.users.singleUser', ['user' => $tra->user]) }}"
                                                class="text-info">{{ $tra->user->name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ Number::currency($tra->amount, $settings->s_currency) }}
                                        </td>
                                        <td>{{ $tra->type }}</td>
                                        <td>{{ $tra->narration }}</td>
                                        <td>
                                            <span @class([
                                                'badge',
                                                'badge-success' => $tra->status == 'completed',
                                                'badge-warning' => $tra->status == 'pending',
                                                'badge-danger' => $tra->status == 'refunded',
                                            ])>{{ Str::ucfirst($tra->status) }}</span>

                                        </td>
                                        <td>
                                            <span class="d-none d-lg-block">
                                                {{ $tra->created_at->toDayDateTimeString() }}
                                            </span>
                                            <span class="d-block d-lg-none">
                                                {{ $tra->created_at->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @can('delete transactions')
                                                <x-ui.button type="button" class="btn-sm btn-danger"
                                                    wire:confirm="Are you sure you want to delete this transaction?"
                                                    wire:click="deleteTransaction('{{ $tra->id }}')">
                                                    <x-spinner wire:loading
                                                        wire:target="deleteTransaction({{ $tra->id }})" />
                                                    <i class="bi bi-trash" wire:loading.remove
                                                        wire:target="deleteTransaction({{ $tra->id }})"></i>
                                                </x-ui.button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No Data Available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
