<x-slot:title>
    Referral Bonus
</x-slot:title>
<div>
    <x-breadcrumbs title="Referral Bonus">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Referral Bonus</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Direct Referral Commission (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission"
                                    wire:model='referral_commission' />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indirect Referral Commission 1 (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission1"
                                    wire:model='referral_commission1' />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indirect Referral Commission 2 (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission2"
                                    wire:model='referral_commission2' />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indirect Referral Commission 3 (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission3"
                                    wire:model='referral_commission3' />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indirect Referral Commission 4 (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission4"
                                    wire:model='referral_commission4' />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indirect Referral Commission 5 (%)</label>
                                <x-form.input type="number" step="any" name="referral_commission5"
                                    wire:model='referral_commission5' />
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
