@php
    $bankTransfer = $this->methods->where('name', 'Bank Transfer')->first();
    $bitcoin = $this->methods->where('name', 'Bitcoin')->first();
    $ethereum = $this->methods->where('name', 'Ethereum')->first();
    $litecoin = $this->methods->where('name', 'Litecoin')->first();
    $usdt = $this->methods->where('name', 'USDT')->first();
@endphp
<div class="card-body">
    <form wire:submit='saveWithdrawalMethod'>
        @if ($bankTransfer->status == 'active')
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label>Bank Name</label>
                    <x-form.input name="bank_name" wire:model='bank_name' placeholder="Enter bank name" />
                </div>
                <div class="mb-3 col-md-6">
                    <label>Account Name</label>
                    <x-form.input name="account_name" wire:model='account_name' placeholder="Enter Account name" />
                </div>
                <div class="mb-3 col-md-6">
                    <label>Account Number</label>
                    <x-form.input name="account_number" wire:model='account_number'
                        placeholder="Enter Account Number" />
                </div>
                <div class="mb-3 col-md-6">
                    <label>Swift Code</label>
                    <x-form.input name="swift_code" wire:model='swift_code' placeholder="Enter Swift Code" />
                </div>
            </div>
        @endif
        <div class="row">
            @if ($bitcoin->status == 'active')
                <div class="mb-3 col-md-6">
                    <label>Bitcoin</label>
                    <x-form.input name="btc_address" wire:model='btc_address' />
                    <small class="h6">Enter your Bitcoin wallet address, your funds will be sent to this
                        address.</small>
                </div>
            @endif

            @if ($ethereum->status == 'active')
                <div class="mb-3 col-md-6">
                    <label>Ethereum</label>
                    <x-form.input name="eth_address" wire:model='eth_address' />
                    <small class="h6">Enter your Ethereum wallet address, your funds will be sent to this
                        address.</small>
                </div>
            @endif

            @if ($litecoin->status == 'active')
                <div class="mb-3 col-md-6">
                    <label>Litecoin</label>
                    <x-form.input name="ltc_address" wire:model='ltc_address' />
                    <small class="h6">Enter your Litcoin wallet address, your funds will be sent to this
                        address.</small>
                </div>
            @endif

            @if ($usdt->status == 'active')
                <div class="mb-3 col-md-6">
                    <label>USDT.TRC20</label>
                    <x-form.input name="usdt_address" wire:model='usdt_address' />
                    <small class="h6">Enter your USDT.TRC20 wallet Address that will be used to withdraw your
                        funds</small>
                </div>
            @endif
        </div>
        @if (
            $usdt->status == 'active' ||
                $bitcoin->status == 'active' ||
                $ethereum->status == 'active' ||
                $litecoin->status == 'active' ||
                $bankTransfer->status == 'active')
            <div class="row">
                <div class="mb-3 text-end col-12">
                    <x-ui.button>
                        <i class="bi bi-floppy" wire:loading.remove wire:target="saveWithdrawalMethod"></i>
                        <x-spinner wire:loading wire:target="saveWithdrawalMethod" />
                        Save
                    </x-ui.button>
                </div>
            </div>
        @else
            <div class="row">
                <div class="text-center col-12">
                    <x-no-data />
                    <h5 class="font-weight-bold">No Withdrawal Method Available</h5>
                </div>
            </div>
        @endif
    </form>
</div>
