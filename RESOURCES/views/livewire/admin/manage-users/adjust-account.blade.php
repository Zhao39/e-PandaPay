<div class="row">
    <div class="col-12">
        <p>Account Adjustment </p>
        <form action="" wire:submit='adjustAccount'>
            <div class="form-row">
                <div class="mb-3 col-lg-6">
                    <x-form.label label="Column" />
                    <x-form.select name='column' wire:model='column' :options="$options" />
                </div>
                <div class="mb-3 col-lg-6">
                    <x-form.label label="Enter Amount" />
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $settings->currency }}</span>
                        </div>
                        <x-form.input type="number" step="any" wire:model="amount" name='amount' required />
                    </div>
                </div>
                <div class="mb-3 col-6">
                    <x-preference label="Adjustment Type">
                        <x-slot:check1>
                            <x-radio name='adjustment' wire:model='adjustment' value="Credit" label="Credit" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='adjustment' wire:model='adjustment' value="Debit" label="Debit" />
                        </x-slot:check2>
                    </x-preference>
                </div>
                <div class="mb-3 col-6">
                    <x-preference label="Create Transaction History">
                        <x-slot:check1>
                            <x-radio name='history' wire:model='history' value="Yes" label="Yes" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='history' wire:model='history' value="No" label="No" />
                        </x-slot:check2>
                    </x-preference>
                </div>
                <div class="mb-3 text-right col-lg-12">
                    <x-ui.button>
                        <i class="bi bi-floppy" wire:loading.remove wire:target="adjustAccount"></i>
                        <x-spinner wire:loading wire:target="adjustAccount" />
                        Submit
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
