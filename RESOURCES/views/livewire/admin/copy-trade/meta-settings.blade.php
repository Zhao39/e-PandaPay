<div class="mt-4 row">
    <div class="alert alert-info" role="alert">
        Our Copytrade feature is powered by <a href="https://metaapi.cloud/">{{ strtoupper('metaapi') }}</a>, a Powerful,
        reliable, fast, scalable, cost-efficient, easy to use and standards-driven websocket API. We usually manage all
        of the accounts for you, but you can manage your accounts yourself. Click on "Use My MetaApi Account" to ge
        started.
    </div>
    <div class="col-12" x-data="{ show: @entangle('use_my_metaapi_account') }">
        <form wire:submit.prevent='save'>
            <div class="form-group">
                <label class="form-check-label">
                    <input type="checkbox" wire:model='use_my_metaapi_account' x-model="show">
                    <span class="form-check-sign">Use My MetaApi Account</span>
                </label>
            </div>
            <div class="form-group" x-show="show" style="display: none" x-transition>
                <label>Enter your Meta Api Token:</label>
                <textarea class="form-control" cols="10" wire:model='meta_api_token'></textarea>
                <small>
                    <a href="https://app.metaapi.cloud/sign-in" target="_blank">Get Token
                        here</a>
                </small>
            </div>
            <div class="form-group">
                <x-ui.button>
                    <x-spinner wire:loading wire:target="save" />
                    Save
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
