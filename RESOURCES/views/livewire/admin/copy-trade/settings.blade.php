<x-slot:title>
    CopyTrade Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Copytrade Settings">
        <li class="nav-item">
            <a href="#">Copytrade Settings</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($settings->use_copytrade)
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Subscription
                                    Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Copytrade
                                    Settings</button>
                            </li>
                        </ul>
                    @endif
                    <div class="mt-4 tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="post" wire:submit.prevent='save'>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>
                                                    Monthly Subscription Fee
                                                    ({{ $settings->currency }})
                                                </label>
                                                <x-form.input type="number" name="monthlyFee" step="any"
                                                    wire:model='monthlyFee' />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Quaterly Subscription Fee
                                                    ({{ $settings->currency }})
                                                </label>
                                                <x-form.input type="number" name="quarterlyFee" step="any"
                                                    wire:model='quarterlyFee' />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>
                                                    Yearly Subscription Fee
                                                    ({{ $settings->currency }})
                                                </label>
                                                <x-form.input type="number" name="yearlyFee" step="any"
                                                    wire:model='yearlyFee' />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>IB Link</label>
                                                <x-form.input name="iblink" wire:model='iblink' />
                                                <small>
                                                    IB Link allows you to set a link for your IB account. This
                                                    link will
                                                    be used to
                                                    redirect your clients to your IB account if they want to
                                                    open a new
                                                    account.
                                                </small>
                                            </div>
                                            <div class="mt-2 form-group col-12">
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
                        @if ($settings->use_copytrade)
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <livewire:admin.copy-trade.payment lazy />
                                <hr />
                                <livewire:admin.copy-trade.meta-settings lazy />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
