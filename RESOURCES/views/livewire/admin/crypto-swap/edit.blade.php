<div class="col-lg-8 offset-lg-2">
    <div class="card">
        <div class="card-body">
            <form wire:submit='saveUpdate'>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label>Currency Name</label>
                        <x-form.input name="name" wire:model.blur='name' placeholder="Bitcoin" required
                            :readOnly="true" />
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Symbol</label>
                        <x-form.input name="symbol" wire:model='symbol' placeholder="BTC" :readOnly="true" required />
                    </div>
                    <div class="form-group col-lg-6">
                        <label>1 {{ $name ? $name : 'token' }} = how many USD($)</label>
                        <x-form.input type="number" step="any" name="price_in_usd" placeholder="54000"
                            wire:model='price_in_usd' required />
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Logo Url</label>
                        <x-form.input name="logo_url" wire:model='logo_url' />
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Logo Size</label>
                        <x-form.input type="number" name="logo_size" wire:model='logo_size' required />
                    </div>
                    <div class="form-group col-md-12">
                        <x-ui.button>
                            <x-spinner wire:loading wire:target="saveUpdate" />
                            Save
                        </x-ui.button>
                        <x-ui.button type="button" class="btn-info" wire:click='cancel'>
                            <x-spinner wire:loading wire:target="cancel" />
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
