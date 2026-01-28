<div class="p-4">
    @if ($method->name !== 'Credit-Debit Card' && $method->name !== 'Paypal')
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if (!empty($method->bank_name))
                    <div class="mb-3">
                        <label>Bank Name</label>
                        <h2 class=" font-weight-bold">{{ $method->bank_name }}</h2>
                    </div>
                @endif
                @if (!empty($method->account_name))
                    <div class="mb-3">
                        <label>Account Name</label>
                        <h2 class=" font-weight-bold">{{ $method->account_name }}</h2>
                    </div>
                @endif
                @if (!empty($method->account_number))
                    <div class="mb-3">
                        <label>Account Number</label>
                        <h2 class=" font-weight-bold">{{ $method->account_number }}</h2>
                    </div>
                @endif
                @if (!empty($method->swift_code))
                    <div class="mb-3">
                        <label>Swift Code</label>
                        <h2 class=" font-weight-bold">{{ $method->swift_code }}</h2>
                    </div>
                @endif
                @if (!empty($method->note))
                    <div class="mb-3">
                        <small>{{ $method->note }}</small>
                    </div>
                @endif
                @include('purpose.deposit.includes.submit-payment')
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            @if ($method->name == 'Credit-Debit Card')
                @if ($settings->credit_card_provider == 'Paystack')
                    @include('purpose.deposit.includes.paystack-payment')
                @endif
                @if ($settings->credit_card_provider == 'Flutterwave')
                    @include('purpose.deposit.includes.flutterwave-payment')
                @endif
                @if ($settings->credit_card_provider == 'Stripe')
                    @include('purpose.deposit.includes.stripe-payment')
                @endif
            @endif
            @if ($method->name == 'Paypal')
                @include('purpose.deposit.includes.paypal-payment')
            @endif
        </div>
    </div>
</div>
