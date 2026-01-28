<x-slot:title>
    Funds Transfer
</x-slot:title>
<div>
    <x-breadcrumbs title="Funds Transfer">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Funds Transfer</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <x-preference label="User to User Funds Transfer">
                                    <x-slot:check1>
                                        <x-radio wire:model='use_transfer' value="1" label="Enable" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='use_transfer' value="0" label="Disable" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Allows users to be able to transfer funds from their account
                                    balance to other
                                    users on your platform.
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Minimum Transfer Amount ({{ $settings->currency }})</label>
                                <x-form.input type="number" name="min_transfer" wire:model='min_transfer' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Transfer Charges(%)</label>
                                <x-form.input type="number" step="any" name="transfer_charges"
                                    wire:model='transfer_charges' required />
                                <small>Enter 0 if you don't want any charges</small>
                            </div>
                            <div class="form-group col-md-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                    <x-spinner wire:loading wire:target="save" />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
