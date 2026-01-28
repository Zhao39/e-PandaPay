<x-slot:title>
    Payment Preference
</x-slot:title>
<div x-data="{ type: 'bank' }">
    <x-breadcrumbs title=" Payment Preference">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"> Payment Preference</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Deposit Option</label>
                                <select wire:model="deposit_option" class="form-control">
                                    <option value="manual">Manual</option>
                                    <option value="auto">Automatic</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label> Withdrawal Option</label>
                                <select wire:model="withdrawal_option" class="form-control">
                                    <option value="manual">Manual</option>
                                    <option value="auto">Automatic</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label> Minimum Deposit Amount ({{ $settings->currency }})</label>
                                <x-form.input name="minamt" wire:model='minamt' required />
                                <small>This amount indicates the minimum amount a user can deposit</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Merchant for automatic crypto Payment:</label>
                                <select wire:model="auto_deposit_merchant" class="form-control">
                                    <option value="Coinpayment">Coinpayment</option>
                                    <option value="Coinbase">Coinbase</option>
                                </select>
                                <small>
                                    Merchant to use for automatic crypto payments when you set deposit option to
                                    automatic.
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Merchant for automatic USDT Payment:</label>
                                <select wire:model="auto_merchant_option" class="form-control">
                                    <option value="Coinpayment">Coinpayment</option>
                                    <option value="Binance">Binance</option>
                                </select>
                                <small>
                                    Please make sure you have entered your API keys for your selected USDT Merchant.
                                    Click the
                                    Gateway/Coinpayment tab to confirm that. NOTE
                                    <strong>Your website currency must be USD in order to use Binance.</strong>
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Withdrawal Deduction</label>
                                <select wire:model="deduction_option" class="form-control">
                                    <option value="userRequest">Deduct on user request</option>
                                    <option value="AdminApprove">Deduct when admin approves</option>
                                </select>
                                <small>
                                    This speciifes if you want users account to be deducted immediately they place a
                                    withdrawal
                                    request or when admin approves it.
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Credit Card Payment Provider</label>
                                <select wire:model="credit_card_provider" class="form-control">
                                    <option>Paystack</option>
                                    <option>Flutterwave</option>
                                    <option>Stripe</option>
                                </select>
                                <small>
                                    Signifies the provder to be used when users choose to deposit with their
                                    credit/debit card
                                    for
                                    credit card option. Ensure you have entered the correct API keys for you selected
                                    option.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <x-preference label="Transfer funds from coinpayment to wallet">
                                    <x-slot:check1>
                                        <x-radio wire:model='coinpayment_to_wallet' value="1" label="Yes" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='coinpayment_to_wallet' value="0" label="No" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    Specifies whether Coinpayment should transfer funds to your wallet address upon user
                                    deposits via Coinpayment. Note make sure you enter a correct/valid wallet address
                                    for that
                                    coin when creating/editing the payment method.
                                </small>
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
