@use('\Illuminate\Support\Number', 'Number')
<div x-data="{ type: 'all', amount: '', useAmount: 'plan_increment_amount' }">
    <form action="" wire:submit='save'>
        <div class="modal-body">
            <div class="row">
                <div class="mb-3 col-12">
                    <div class="form-check">
                        <label>Add to </label> <br>
                        <label class="form-radio-label">
                            <input class="form-radio-input" @click="type = 'all'" type="radio" name="type"
                                wire:model='type' value="all">
                            <span class="form-radio-sign">Selected Plan</span>
                        </label>
                        <label class="ml-3 form-radio-label">
                            <input class="form-radio-input" @click="type = 'single'" type="radio" name="type"
                                wire:model='type' value="single">
                            <span class="form-radio-sign">Single Plan</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3 col-12" x-show="type == 'all'">
                    <x-form.label>Select Plan</x-form.label>
                    <select class="form-control" wire:model='plan'>
                        <option>Select..</option>
                        @foreach ($this->plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan')
                            <small class="text-xs text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 col-12" x-show="type == 'single'" style="display: none" wire:ignore>
                    <x-form.label>Select User Plan</x-form.label>
                    <select class="select2 form-control" style="width: 100%">
                        <option value="select">Select...</option>
                        @foreach ($this->usersPlans as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->user->name }} -
                                Plan:
                                {{ $plan->plan->name }}
                                Amount:
                                {{ Number::currency($plan->amount, $settings->s_currency) }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error('userPlan')
                            <small class="text-xs text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check">
                        <label>Amount to calculate </label> <br>
                        <label class="form-radio-label">
                            <input class="form-radio-input" @click="useAmount = 'plan_increment_amount'" type="radio"
                                name="useAmount" wire:model='useAmount' value="plan_increment_amount">
                            <span class="form-radio-sign">Plan increment amount</span>
                        </label>
                        <label class="ml-3 form-radio-label">
                            <input class="form-radio-input" @click="useAmount = 'enter_amount'" type="radio"
                                name="useAmount" wire:model='useAmount' value="enter_amount">
                            <span class="form-radio-sign">Enter Amount</span>
                        </label>
                    </div>
                    <small x-show="useAmount == 'plan_increment_amount'">
                        The system will calculate the ROI base on users invested amount and increment amount specified
                        in the selected plan settings.
                    </small>
                </div>
                <div class="mb-3 col-12" x-show="useAmount == 'enter_amount'" style="display: none">
                    <x-form.label label="Enter Amount" />
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-expanded="false">{{ $amount_type }}</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" wire:click="$set('amount_type', 'Percent')"
                                    href="#">Percent(%)</a>
                                <a class="dropdown-item" wire:click="$set('amount_type', 'Fixed')"
                                    href="#">Fixed({{ $settings->currency }})</a>
                            </div>
                        </div>
                        <x-form.input type="number" x-model='amount' placeholder="Amount" step="any"
                            wire:model="amount" name='amount' x-bind:required="useAmount == 'enter_amount'" />
                    </div>
                    <small style="font-size: 10px" class="m-0">
                        @if ($amount_type == 'Percent')
                            Amount will be calculated with % of the user investment capital.
                        @else
                            This fixed amount entered will be added.
                        @endif
                    </small>
                </div>
                <div class="mb-3 col-lg-6">
                    <x-preference label="Add to user Account Balance">
                        <x-slot:check1>
                            <x-radio name='addToAccountBalance' wire:model='addToBalance' value="1"
                                label="Add" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='addToAccountBalance' wire:model='addToBalance' value="0"
                                label="Dont't Add" />
                        </x-slot:check2>
                    </x-preference>
                </div>
                {{-- <div class="col-12">
                    <small class=" font-weight-bold">Note the plan must be using % as it's increment-type else the
                        calculations will be
                        wrong.
                    </small>
                </div> --}}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:loading.attr='disabled' wire:target="save"
                data-dismiss="modal" @click="amount = ''">Cancel</button>
            <x-ui.button>
                <x-spinner wire:loading wire:target="save" />
                Submit
            </x-ui.button>
        </div>
    </form>
</div>
@script
    <script>
        const selects = $('.select2');
        selects.select2({
            placeholder: "Select Plan",
            allowClear: true
        });
        selects.on('change', function() {
            $wire.userPlan = this.value;
        });
    </script>
@endscript
