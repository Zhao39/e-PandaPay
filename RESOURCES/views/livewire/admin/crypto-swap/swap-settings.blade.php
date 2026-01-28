@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Swap Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Swap Settings">
        <li class="nav-item">
            <a href="#">Swap Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-group col-12">
                            <label>Use Price from our API for our Default Currencies</label>
                            <x-preference label="">
                                <x-slot:check1>
                                    <x-radio wire:model='use_api_price_for_swap' value="1" label="Yes" />
                                </x-slot:check1>
                                <x-slot:check2>
                                    <x-radio wire:model='use_api_price_for_swap' value="0" label="No" />
                                </x-slot:check2>
                            </x-preference>
                            <small class="d-block">
                                If this is No, you will need to manually
                                enter the amount to USD which
                                will be used for
                                calculationg the prices.
                            </small>
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Swap Fee (%)</label>
                            <x-form.input type="number" step="any" name="swap_fee" wire:model='swap_fee'
                                required />
                            <small>
                                This fee will be calculated while users enter the amount they want to swap.
                            </small>
                        </div>
                        <div class="text-right form-group">
                            <x-ui.button>
                                <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                <x-spinner wire:loading wire:target="save" />
                                Save
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
