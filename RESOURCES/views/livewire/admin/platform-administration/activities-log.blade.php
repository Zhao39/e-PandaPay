<x-slot:title>
    Activities Log
</x-slot:title>
<div>
    <x-breadcrumbs title="Activities Log">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>Platform
                Administration</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Activities Log</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="mb-2">
                            <x-form.label label="Order" />
                            <x-form.select wire:model.live='order' :options="[
                                'desc' => 'Latest',
                                'asc' => 'Oldest',
                            ]" />
                        </div>
                        <div class="d-flex">
                            <div class="mb-2 mr-2">
                                <x-form.label label="From" />
                                <x-form.input type="date" wire:model.live="fromDate" />
                            </div>
                            <div class="mb-2 mr-2">
                                <x-form.label label="To" />
                                <x-form.input type="date" wire:model.live="toDate" />
                            </div>
                            @if ($fromDate != '' && $toDate != '')
                                <div class="mb-2">
                                    <x-ui.button type="button" class="btn-sm" wire:click='resetFilter'>
                                        reset
                                    </x-ui.button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Causer</th>
                                    <th>Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr wire:key="{{ $activity->id }}">
                                        <td>
                                            {{ $activity->description }}
                                            {{ $activity->properties ? json_encode($activity->properties) : '' }}
                                        </td>
                                        <td>{{ $activity->causer->name }}</td>
                                        <td>
                                            {{ $activity->created_at->inUserTimezone()->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No Activity Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
