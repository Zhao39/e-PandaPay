@use('\Illuminate\Support\Number', 'Number')
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            Plan Details
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="d-lg-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="text-black font-weight-bold">
                                    {{ $plan->plan->name }} -
                                    {{ $roiInfo }}
                                    for {{ $plan->plan->duration }}
                                </h2>
                                @if ($plan->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($plan->status == 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            @if ($settings->should_cancel_plan && $plan->status == 'active')
                                <div class="text-right">
                                    <button class="btn btn-danger btn-sm" wire:click='cancelPlan'
                                        wire:loading.attr="disabled" wire:target='cancel'>
                                        <x-spinner wire:loading wire:target='cancelPlan' />
                                        <i class=" bi bi-x-circle" wire:loading.remove wire:target='cancelPlan'>
                                        </i>
                                        <span wire:loading wire:target='cancel'>Cancelling..</span>
                                        <span wire:loading.remove wire:target='cancel'> Cancel Plan</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mb-5 d-flex justify-content-around align-items-center">
                        <div>
                            <h2 class="m-0">
                                {{ Number::currency($plan->amount, $settings->s_currency) }}
                            </h2>
                            <small>Invested amount</small>
                        </div>
                        <div> + &nbsp;</div>
                        <div>
                            <h2 class="m-0 text-success">
                                {{ Number::currency($plan->profit_earned, $settings->s_currency) }}
                            </h2>
                            <small>Profit earned</small>
                        </div>
                        <div> = &nbsp;</div>
                        <div>
                            <h2 class="m-0 text-success">
                                @if ($settings->return_capital)
                                    {{ Number::currency($plan->amount + $plan->profit_earned, $settings->s_currency) }}
                                @else
                                    {{ Number::currency($plan->profit_earned, $settings->s_currency) }}
                                @endif
                            </h2>
                            <small>Total Return</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <p>Duration: <br><strong>{{ $plan->plan->duration }}</strong> </p>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <p>Start Date: <br>
                                <strong>{{ $plan->created_at->toDayDateTimeString() }}</strong>
                            </p>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <p>End Date:
                                <br><strong>{{ $plan->expire_date->toDayDateTimeString() }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <p>Minimum Return: <br> <strong>{{ $plan->plan->min_return }}%</strong></p>

                        </div>
                        <div class="mb-3 col-lg-4">
                            <p>Maximum Return: <br> <strong>{{ $plan->plan->max_return }}%</strong> </p>
                        </div>
                        <div class="mb-3 col-lg-4">
                            <p>
                                ROI Interval:<br>
                                <strong>{{ $plan->plan->increment_interval }}</strong>
                            </p>
                        </div>
                    </div>
                    @can('see profit history')
                        <div class="mt-5">
                            <h4 class="font-weight-bold">
                                ROI History
                            </h4>
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Amount</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col" class="text-end">Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roiHistory as $history)
                                        <tr>
                                            <td>
                                                {{ Number::currency($history->amount, $settings->s_currency) }}
                                            </td>
                                            <td colspan="4" class="text-end">
                                                {{ $history->created_at->toDayDateTimeString() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">No ROI record yet</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{ $roiHistory->links() }}
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
