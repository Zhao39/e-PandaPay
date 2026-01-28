<x-slot:title>
    Reg & Deposit Bonus
</x-slot:title>
<div>
    <x-breadcrumbs title="Reg & Deposit Bonus">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Reg & Deposit Bonus</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Registration Bonus ({{ $settings->currency }})</label>
                                <x-form.input type="number" step="any" name="signup_bonus"
                                    wire:model='signup_bonus' />
                                <small>Bonus will be added to new users account once they signup.</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Deposit Bonus (%)</label>
                                <x-form.input type="number" step="any" name="deposit_bonus"
                                    wire:model='deposit_bonus' />
                                <small>
                                    You can specify the bonus amount for users deposit. The system calculates the
                                    percantage amount you specified with the amount of the users deposit and adds it as
                                    a bonus (For every deposit).</small>
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
