@use('\Illuminate\Support\Number', 'Number')
<x-slot:title>
    Profit History
</x-slot:title>
<div>
    <x-breadcrumbs title="Profit History">
        <li class="nav-item">
            <a href="{{ route('admin.usersPlans') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Users Plans
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ $userPlan->user->name }}'s {{ $userPlan->plan->name }} plan.</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="mb-2 col-12">
            <div class="text-right">
                <a href="{{ route('admin.usersPlans') }}" class="btn btn-primary"
                    @if ($settings->spa_mode) wire:navigate @endif>
                    <i class="fas fa-arrow-alt-circle-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="mb-2">
                            <x-form.label label="Order" />
                            <x-form.select wire:model.live='order' :options="[
                                'desc' => 'Descending',
                                'asc' => 'Ascending',
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
                            <thead class="text-center bg-light">
                                <tr>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date/Time</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($rois as $roi)
                                    <tr wire:key='{{ $roi->id }}'>
                                        <td>{{ $userPlan->plan->name }}</td>
                                        <td>
                                            {{ Number::currency($roi->amount, $settings->s_currency) }}
                                            @if ($userPlan->plan->increment_type == 'Percentage')
                                                <small style="font-size: 9px">{{ $roi->rate }}% </small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $roi->created_at->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No Data Available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $rois->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
