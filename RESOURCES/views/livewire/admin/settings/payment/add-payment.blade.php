<div class="col-lg-8 offset-lg-2">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.payment.addMethod') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label>Method Name</label>
                        <x-form.input name="name" wire:model='name' required />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Minimum Amount ({{ $settings->currency }})</label>
                        <x-form.input type="number" name="minimum" wire:model='minimum' required />
                        <small>Minimum Amount to withdraw.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Maximum Amount ({{ $settings->currency }})</label>
                        <x-form.input type="number" name="maximum" wire:model='maximum' required />
                        <small> Only applies to withdrawal</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Withdrawal Charges Type</label>
                        <select wire:model='charges_type' class="form-control">
                            <option value="percentage">Percentage(%)</option>
                            <option value="fixed">Fixed({{ $settings->currency }})</option>
                        </select>
                        <small>Required but only applies to withdrawal</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Withdrawal Charges Amount</label>
                        <x-form.input type="number" step="any" name="charges_amount" wire:model='charges_amount'
                            required />
                        <small>Required but only applies to withdrawal</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Method Type</label>
                        <select wire:model.live="methodtype" name="methodtype" class="form-control">
                            <option value="currency">Currency</option>
                            <option value="crypto">Crypto</option>
                        </select>
                    </div>

                    @if ($methodtype === 'currency')
                        {{-- Currency inputs --}}
                        <div class="col-12 form-group">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Bank Name</label>
                                    <x-form.input name="bank_name" wire:model='bank_name' :required="$methodtype === 'currency'" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Account Name</label>
                                    <x-form.input name="account_name" wire:model='account_name' :required="$methodtype === 'currency'" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Account Number</label>
                                    <x-form.input type="number" name="account_number" wire:model='account_number'
                                        :required="$methodtype === 'currency'" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Swift/Other Code</label>
                                    <x-form.input name="swift_code" wire:model='swift_code' />
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($methodtype === 'crypto')
                        {{-- Cryptocurrency Inputs --}}
                        <div class="col-12 form-group">
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Wallet Address</label>
                                    <x-form.input name="wallet_address" wire:model='wallet_address' :required="$methodtype === 'crypto'" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Symbol</label>
                                    <x-form.input name="coin" wire:model='coin' placeholder="BTC"
                                        :required="$methodtype === 'crypto'" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Barcode Image (Optional)</label>
                                    <x-form.input type="file" name="barcode" wire:model='barcode' />
                                    <small>
                                        Recommended Size: 575px both width and height
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Wallet Address Network Type</label>
                                    <x-form.input name="network" placeholder="eg ERC 20" wire:model='network' />
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <select wire:model="status" name="status" class="form-control">
                            <option value="active">Enable</option>
                            <option value="inactive">Disable</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Type for</label>
                        <select wire:model="type" name="type" class="form-control">
                            <option value="withdrawal">Withdrawal</option>
                            <option value="deposit">Deposit</option>
                            <option value="both">Both Withdrawal & Deposit</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Image url (Logo)</label>
                        <x-form.input name="img_url" wire:model='img_url' />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Optional Note or Instructions</label>
                        <x-form.input name="note" wire:model='note' placeholder="Payment may take up to 24 hours" />
                    </div>
                    <div class="form-group col-md-12">
                        <x-ui.button>
                            <x-spinner wire:loading wire:target="save" />
                            Save Method
                        </x-ui.button>
                        <x-ui.button type="button" class="btn-secondary" wire:click='cancel'>
                            <x-spinner wire:loading wire:target="cancel" />
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
