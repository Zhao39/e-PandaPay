@use('\Illuminate\Support\Number', 'Number')
<div>
    <x-breadcrumbs title="My investment plans" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">My investment plans</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 mb-lg-5 d-flex justify-content-between align-items-center">
                <div>
                    <select class="custom-select custom-select-sm form-control" wire:model.live='sort_value'>
                        <option value="All">All</option>
                        <option value="active">Active</option>
                        <option value="cancelled">Cancelled/Inactive</option>
                        <option value="expired">Expired</option>
                    </select>
                    <x-spinner wire:loading wire:target="sort_value" />
                </div>

                <div>
                    @if (auth()->user()->trade_mode)
                        <span class="text-white badge bg-success">Trade Mode is on</span>
                    @else
                        <span class="text-white badge bg-danger">Trade Mode is off</span>
                    @endif
                </div>
            </div>
            <div class="row">
                @forelse ($plans as $plan)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="font-weight-bold"> {{ $plan->plan->name }}</h4>
                                    </div>
                                    <div>
                                        @if ($plan->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif($plan->status == 'expired')
                                            <span class="badge badge-danger">Expired</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-1 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Amount:</h5>
                                    </div>
                                    <div>
                                        <span> {{ Number::currency($plan->amount, $settings->s_currency) }}</span>
                                    </div>
                                </div>
                                <div class="mb-1 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Started At</h5>
                                    </div>
                                    <div>
                                        <span> {{ $plan->created_at->toDayDateTimeString() }}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Ended At</h5>
                                    </div>
                                    <div>
                                        <span> {{ $plan->expire_date->toDayDateTimeString() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('user.investment.plandetails', ['plan' => $plan]) }}"
                                    class="btn btn-primary btn-sm"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    View details
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="card">
                            <div class="text-center card-body">
                                <x-no-data />
                                <h5> No Data Avaiable</h5>
                                @if ($sort_value == 'All')
                                    <a href="{{ route('user.investment.buyplan') }}" class="px-3 btn btn-primary">
                                        Buy plan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
