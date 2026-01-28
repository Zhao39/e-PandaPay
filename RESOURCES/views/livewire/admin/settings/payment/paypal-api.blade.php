<x-slot:title>
    Paypal Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Paypal Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Paypal Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client ID</label>
                                <x-form.input name="pp_ci" wire:model='pp_ci' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Client Secret</label>
                                <x-form.input name="pp_cs" wire:model='pp_cs' required />
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
                                    You can get the following details from <a
                                        href="https://developer.paypal.com/api/rest/" target="_blank">Paypal's
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
