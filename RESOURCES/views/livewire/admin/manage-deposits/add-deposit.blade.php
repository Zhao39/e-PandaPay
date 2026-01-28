<div x-data="{ amount: '' }">
    <form action="" wire:submit='save'>
        <div class="modal-body">
            <div class="row">
                <div class="mb-3 col-12" wire:ignore>
                    <x-form.label>Select User</x-form.label>
                    <select class="select2 form-control" style="width: 100%">
                        <option selected disabled>Select User..</option>
                        @foreach ($this->users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-lg-6">
                    <x-form.label label="Enter Amount" />
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $settings->currency }}</span>
                        </div>
                        <x-form.input type="number" x-model='amount' step="any" wire:model="amount" name='amount'
                            required />
                    </div>
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
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:loading.attr='disabled' data-dismiss="modal"
                @click="amount = ''">Cancel</button>
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
            placeholder: "Select User",
            allowClear: true
        });
        selects.on('change', function() {
            $wire.userId = this.value;
        });
    </script>
@endscript
