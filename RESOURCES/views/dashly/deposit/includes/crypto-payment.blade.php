<div class="row">
    <div class="p-3 col-lg-8 offset-lg-2" x-data="{
        copied: false,
        address: '{{ $method->wallet_address }}',
        copyToClipboard(text) {
            if (!navigator.clipboard) {
                return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
            }
            navigator.clipboard.writeText(text)
                .then(() => {
                    this.copied = true
                    setTimeout(() => {
                        this.copied = false
                    }, 3000)
                })
        },
    }">
        @if ($settings->deposit_option == 'manual')
            @if (!empty($method->barcode))
                <div class="text-center">
                    <p class="m-0">Scan the barcode below to make payment</p>
                    <img src="{{ asset('storage/' . $method->barcode) }}" alt="" class="m-0 img-fluid w-25">
                </div>
            @endif
            <div class="p-3 mt-5">
                <div>
                    <p class="m-0">
                        Send {{ $settings->currency }}{{ $amount }} to the
                        address below
                    </p>
                    <div class="input-group">
                        <x-form.input value="{{ $method->wallet_address }}" readonly />
                        <div class="input-group-append">
                            <button x-bind:class="copied ? 'btn btn-outline-success' : 'btn btn-outline-secondary'"
                                x-on:click="copyToClipboard(address)" type="button">
                                <i class="bi bi-copy fs-3" x-show="!copied"></i>
                                <i class="bi bi-check-lg" x-show="copied" style="display: none"
                                    x-transition.scale.origin.right.opacity></i>
                            </button>
                        </div>
                    </div>
                    @if ($method->network)
                        <small class="mt-1 d-block">
                            <strong>Network Type:</strong>
                            {{ $method->network }}
                        </small>
                    @endif
                </div>
            </div>
            @include('dashly.deposit.includes.submit-payment')
        @endif
        @if ($settings->deposit_option != 'manual')
            <div class="py-4 text-center">
                @if ($method->name == 'USDT' && $settings->auto_merchant_option == 'Binance' && $settings->deposit_option == 'auto')
                    <div>
                        <button type="button" class="btn btn-primary" wire:click='payViaBinance'
                            wire:loading.attr="disabled">
                            <img src="https://seeklogo.com/images/B/binance-coin-bnb-logo-CD94CC6D31-seeklogo.com.png"
                                wire:loading.remove wire:target="payViaBinance" alt="" width="20">
                            <x-spinner wire:loading wire:target="payViaBinance" />
                            <span>Pay Via Binance</span>
                        </button>
                    </div>
                @else
                    <div>
                        @if (!$hasQrcode)
                            <button type="button" class="btn btn-primary" wire:click='payViaCoinpayment'
                                wire:loading.attr="disabled">
                                <img src="https://i.pinimg.com/280x280_RS/d4/24/dd/d424dd7174f2e041c1d40e6037611bd7.jpg"
                                    wire:loading.remove wire:target="payViaCoinpayment" width="20">
                                <x-spinner wire:loading wire:target="payViaCoinpayment" />
                                <span> Pay Via Coinpayment</span>
                            </button>
                        @endif
                        @if ($hasQrcode)
                            <div class="text-center">
                                <h5>
                                    Send {{ Number::currency($amount, $settings->s_currency) }} to the below address or
                                    scan the {{ $method->coin }} QR code to complete payment.
                                </h5>
                                <h4><strong>{{ $coinpayment_address }}</strong></h4>
                                <div>
                                    <img width="220" height="220" alt="Payment QR code" src="{{ $qrcode }}">
                                </div>
                                <div class="mt-3">
                                    <small class="mb-2 d-block">
                                        you can exit this page after scanning and completed payment, the
                                        system will keep track of your payment and update your account
                                        accordingly.
                                    </small>
                                    <a href="{{ route('user.deposit.make') }}" class="btn btn-primary btn-sm"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <i class="bi bi-check text-success"></i>
                                        Completed, Exit
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
