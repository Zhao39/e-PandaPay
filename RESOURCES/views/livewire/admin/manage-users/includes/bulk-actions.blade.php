<div class="mb-3 text-right">
    <a href="" @click.prevent="bulkAction = ''">
        <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
    </a>
</div>
<div x-show="bulkAction == 'adjust'">
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
<div x-show="bulkAction == 'clear'">
    <h5 class="text-muted font-weight-bold">
        You are about to clear account for selected users. This Action is not reversible
    </h5>
    <form action="" wire:submit='clearAccount'>
        <div class="mb-3">
            <x-form.label label="Choose what to clear" />
            <x-form.select label="whatToClear" wire:model.live='whatToClear' :options="[
                'account_bal' => 'Account Balance',
                'roi' => 'Profit Column',
                'bonus' => 'Bonus Column',
                'ref_bonus' => 'Referral Bonus Column',
                'deposits' => 'Deposit Record',
                'withdrawal' => 'Withdrawal Record',
                'transaction' => 'Transaction History',
                'plans' => 'Investment Plans',
            ]" multiple required />
        </div>
        <div class="mb-3">
            <x-ui.button>
                <x-spinner wire:loading wire:target="clearAccount" />
                Submit
            </x-ui.button>
        </div>
    </form>
</div>
<div x-show="bulkAction == 'delete'">
    <h5 class="m-0 text-muted font-weight-bold">You are about to delete the selected accounts. This Action is not
        reversible</h5>
    <x-ui.button class="m-1 btn-danger" type="button" wire:click='deleteAccount'
        wire:confirm='Are you sure you want to delete these accounts'>
        <x-spinner wire:loading wire:target="deleteAccount" />
        Yes, Delete
    </x-ui.button>
</div>
