<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-sm font-weight-bold">Add plan</h5>
            <div>
                <a href="" class="text-dark" wire:click.prevent='resetProps'>
                    <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                </a>
            </div>
        </div>
        <div>
            <form method="post" wire:submit='createPlan'>
                <div class="form-row">
                    <div class="mb-3 col-md-6">
                        <label class="">Plan Name</label>
                        <x-form.input name="name" wire:model='name' required />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>
                            Plan Price({{ $settings->currency }})
                        </label>
                        <x-form.input type="number" step="any" name="price" wire:model='price' required />
                        <small class="text-xs">This is the maximum amount a user can pay
                            to invest in this plan.</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Plan Minimum Price({{ $settings->currency }})</label>
                        <x-form.input type="number" step="any" name="min_price" wire:model='min_price' required />
                        <small class="textxs">This is the minimum amount a user can pay
                            to invest in this plan.</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Plan Maximum Price({{ $settings->currency }})</label>
                        <x-form.input type="number" step="any" name="max_price" wire:model='max_price' required />
                        <small class="text-xs">Same as plan price.</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Minimum return (%)</label>
                        <x-form.input type="number" step="any" name="min_return" wire:model='min_return'
                            required />
                        <small class="text-xs">This is the minimum return (ROI) for this
                            plan.</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Maximum return (%)</label>
                        <x-form.input type="number" step="any" name="max_return" wire:model='max_return'
                            required />
                        <small>This is the Maximum return (ROI) for this plan</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Gift Bonus ({{ $settings->currency }})</label>
                        <x-form.input type="number" step="any" name="bonus" wire:model='bonus' required />
                        <small class="text-xs">Optional Bonus if a user buys this plan. </small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Increment Interval</label>
                        <x-form.select name="increment_interval" wire:model='increment_interval' :options="$intervalOptions"
                            required />
                        <small class="text-xs">
                            This specifies how often the system should add profit(ROI) to user account.
                        </small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Increment Type</label>
                        <x-form.select name="increment_type" wire:model='increment_type' :options="$topupTypeOptions" required />
                        <small class="text-xs">This specifies if the system should add
                            profit in percentage(%) or a fixed amount.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Increment Amount(s) (in % or
                            {{ $settings->currency }} as specified above)</label>
                        <x-form.input type="text" name="increment_amount" wire:model='increment_amount' required />
                        <small class="text-xs">
                            This is the amount the system will add to
                            users account as profit, based on what you selected in topup type and topup
                            interval above.
                            Note: you can specify a single value or multiple values seperated by comma(,), and the
                            system will
                            randomly pick one of the
                            values to calculate the ROI for users. eg 2.1, 4, 5.2, 7.3 etc.(max:150 characters), or a
                            single
                            value: eg 3.5.
                        </small>
                    </div>

                    <div class="mb-3 col-md-6" x-data="{ show: false }">
                        <label>Investment Duration</label>
                        <x-form.input name="duration" wire:model='duration' required
                            placeholder="eg 1 Days, 2 Weeks, 1 Months" required />
                        <small>
                            This specifies how long the investment plan
                            will run. Strictly follow
                            <a href="" @click.prevent="show=true" class="text-primary">
                                this Guide</a>
                        </small>
                        <div class="alert alert-primary" x-show="show" x-transition>
                            <div class="mb-2 text-right">
                                <a href="" @click.prevent="show = false">
                                    <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                                </a>
                            </div>
                            <h5 class="">
                                FIRSTLY, Always preceed the time frame with a digit, that is
                                do not write the number in letters, <br> <br> SECONDLY, always add space after the
                                number, <br>
                                <br> LASTLY, the first letter of the timeframe should be in CAPS.
                            </h5>
                            <h2 class="">Eg, 1 Day, 3 Weeks, 1 Hour, 48 Hours, 4 Months, 1 Year, 9
                                Months</h2>
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <x-ui.button> Submit </x-ui.button>
                        <x-ui.button type='button' class="btn-danger" wire:click='resetProps'>
                            <x-spinner wire:loading wire:target="resetProps" />
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
