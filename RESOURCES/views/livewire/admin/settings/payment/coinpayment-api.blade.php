<x-slot:title>
    Coinpayment Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Coinpayment Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Coinpayment Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Merchant ID</label>
                                <x-form.input name="cp_m_id" wire:model='cp_m_id' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>CoinPayment IPN Secret</label>
                                <x-form.input name="cp_ipn_secret" wire:model='cp_ipn_secret' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>CoinPayments Debug Email</label>
                                <x-form.input type="email" name="cp_debug_email" wire:model='cp_debug_email'
                                    required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Public key</label>
                                <x-form.input name="cp_p_key" wire:model='cp_p_key' required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Private key</label>
                                <x-form.input name="cp_pv_key" wire:model='cp_pv_key' required />
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
                                    You can get the following details from <a href="https://www.coinpayments.net/"
                                        target="_blank">coinpayment's
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
