@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Users investment plans
</x-slot:title>
<div>
    <x-breadcrumbs title="Users investment plans">
        <li class="nav-item">
            <a href="#">Users Plans</a>
        </li>
    </x-breadcrumbs>
    @can('manually add profit')
        <div class="mb-2 row">
            <div class=" col-12">
                <div class="text-right">
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addProfitModal">
                        <i class="fa fa-plus"></i>
                        Add Profit
                    </a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addProfitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog dark">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Profit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <livewire:admin.investment-plan.add-profit />
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
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="mb-2">
                            <x-form.label label="Status" />
                            <x-form.select wire:model.live='status' :options="[
                                'All' => 'All',
                                'active' => 'Active',
                                'expired' => 'Expired',
                                'cancelled' => 'Cancelled',
                            ]" />
                        </div>
                        <div class="mb-2">
                            <x-form.label label="Customer" />
                            <select wire:model.live='user' class="form-control ">
                                <option value="All">All</option>
                                @foreach ($this->users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <x-form.label label="Per Page" />
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
                    @if ($this->usersPlans->count() === 0)
                        <div class="text-center">
                            <img src="{{ asset('themes/default/assets/media/auth/404.png') }}" alt=""
                                class="w-25">
                            @if ($user != 'All' && $status != 'All' && ($fromDate != '' && $toDate != ''))
                                <h1 class="mt-3 font-weight-bolder text-info">No Result found</h1>
                                <p>We couldn't find what you are looking for. Try again.</p>
                                <button type="button" class="btn btn-dark" wire:click='resetFilter'>
                                    Try again
                                </button>
                            @else
                                <div class="text-center">
                                    <x-no-data />
                                    <h4>When Users invest, their plan will show here.</h4>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <button @click="showfilters = !showfilters" class="border btn btn-light" type="button">
                                    <i class="fas fa-filter"></i>
                                    Filters
                                </button>
                            </div>
                            <div>
                                <button class="border btn btn-light" type="button" wire:click="$refresh">
                                    <i class="fas fa-sync"></i>
                                    Reload record
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Amount Invested</th>
                                        <th>Plan</th>
                                        <th>Profit Earned</th>
                                        <th>Start Date</th>
                                        <th>Expiration Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->usersPlans as $userPlan)
                                        <tr wire:key='{{ $userPlan->id }}'>
                                            <td>
                                                <a class=" text-underline text-info"
                                                    @if ($settings->spa_mode) wire:navigate @endif
                                                    href="{{ route('admin.users.singleUser', ['user' => $userPlan->user]) }}">
                                                    {{ $userPlan->user->name }}
                                                </a>
                                            </td>
                                            <td>{{ Number::currency($userPlan->amount, $settings->s_currency) }}</td>
                                            <td>{{ $userPlan->plan->name }}</td>
                                            <td>
                                                {{ Number::currency($userPlan->profit_earned, $settings->s_currency) }}
                                            </td>
                                            <td>
                                                <span class="d-none d-lg-block">
                                                    {{ $userPlan->created_at->toDayDateTimeString() }}
                                                </span>
                                                <span class="d-block d-lg-none">
                                                    {{ $userPlan->created_at->format('d M, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="d-none d-lg-block">
                                                    {{ $userPlan->expire_date->toDayDateTimeString() }}
                                                </span>
                                                <span class="d-block d-lg-none">
                                                    {{ $userPlan->expire_date->format('d M, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    @class([
                                                        'badge',
                                                        'badge-danger' => $userPlan->status == 'expired',
                                                        'badge-success' => $userPlan->status == 'active',
                                                        'badge-warning' => $userPlan->status == 'cancelled',
                                                    ])>{{ Str::ucfirst($userPlan->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('edit users plan')
                                                            @if ($userPlan->status == 'active')
                                                                <a class="dropdown-item text-warning" href="#"
                                                                    wire:click.prevent="markAsExpired({{ $userPlan->id }})">Mark
                                                                    as expired</a>
                                                            @else
                                                                <a class="dropdown-item" href="#"
                                                                    wire:click.prevent="markAsActive({{ $userPlan->id }})">Mark
                                                                    as active</a>
                                                            @endif
                                                        @endcan
                                                        @can('see users plan profit history')
                                                            <a class="dropdown-item"
                                                                @if ($settings->spa_mode) wire:navigate @endif
                                                                href="{{ route('admin.profitHistory', ['userPlan' => $userPlan]) }}">
                                                                Profit History
                                                            </a>
                                                        @endcan
                                                        @can('delete users plan')
                                                            <a class="dropdown-item text-danger" data-toggle="modal"
                                                                data-target="#deleteModal"
                                                                wire:click.prevent="$set('planId', {{ $userPlan->id }})"
                                                                href="#">Delete</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $this->usersPlans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Plan Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog dark" role="document">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure want to delete this plan?</h4>
                    <p>This action is non reversible</p>
                    <div class="float-right text-right">
                        <button type="button" class="btn btn-secondary close-btn"
                            data-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="deletePlan" class="btn btn-danger close-modal"
                            data-dismiss="modal">Yes,
                            Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Delete Plan Modal --}}
</div>
