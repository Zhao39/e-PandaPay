@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    KYC Applications
</x-slot:title>
<div>
    <x-breadcrumbs title="KYC Applications">
        <li class="nav-item">
            <a href="#"> KYC Applications</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($applications->count() === 0)
                        <div class="text-center">
                            <x-no-data />
                            @if ($search != '' || $status != 'All')
                                <h1 class="font-weight-bolder text-info">No Result found</h1>
                                <p>We couldn't find what you are looking for. Try again.</p>
                                <button type="button" class="btn btn-primary" wire:click='resetFilter'>
                                    Try again
                                </button>
                            @else
                                <h5 class="font-weight-bolder text-info">No Data found</h5>
                            @endif
                        </div>
                    @else
                        <div class="mb-3 d-lg-flex justify-content-between">
                            <div class="d-lg-flex">
                                <div class="mb-1 mr-2">
                                    <x-form.select wire:model.live='status' :options="[
                                        'All' => 'All',
                                        'verified' => 'Verified',
                                        'under review' => 'Pending',
                                    ]" />
                                </div>
                                <div class="mb-1">
                                    <x-form.input type="text" class="rounded" placeholder="Search"
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
                                        <th>Customer</th>
                                        <th>KYC Status</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $list)
                                        <tr>
                                            <td>
                                                {{ $list->user->name }}
                                            </td>
                                            <td>
                                                @if ($list->status == 'verified')
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        {{ Str::ucfirst($list->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $list->created_at->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.processKycApplication', ['kyc' => $list]) }}"
                                                    class="btn btn-primary btn-sm"
                                                    @if ($settings->spa_mode) wire:navigate @endif>
                                                    View application
                                                </a>
                                                @can('delete kyc applications')
                                                    <a href="" wire:click.prevent="delete('{{ $list->id }}')"
                                                        class="btn btn-danger btn-sm" wire:loading.attr='disabled'
                                                        wire:confirm='Are you sure you want to delete, this will require the user to apply again?'>
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $list->id }}')" />
                                                        Delete
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
