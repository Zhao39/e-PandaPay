<x-slot:title>
    Binance Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Coinbase API Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Coinbase API Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>API Key</label>
                                <x-form.input name="coinbase_apikey" wire:model='coinbase_apikey' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>API Version</label>
                                <x-form.input name="coinbase_apiversion" wire:model='coinbase_apiversion' required />
                            </div>
                            <div class="form-group col-md-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                    <x-spinner wire:loading wire:target="save" />
                                    Save
                                </x-ui.button>
                            </div>
                            <div class="form-group col-12">
                                <small>
                                    You can get the following details from <a href="https://coinbase.com/"
                                        target="_blank">coinbase
                                        website <i class="bi bi-arrow-up-right"></i></a>.
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
