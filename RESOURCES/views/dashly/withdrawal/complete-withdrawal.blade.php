<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-md-2">
                    <div class="mb-3">
                        <h4 class="h2"> <i class="bi bi-cursor"></i> {{ $method->name }}</h4>
                    </div>
                    <form wire:submit='save'>
                        <div class="mb-3 form-group">
                            <label> Amount({{ $settings->currency }}) </label>
                            <x-form.input wire:model='amount'
                                placeholder="Enter amount to withdraw in {{ $settings->s_currency }}" type="number"
                                name="amount" required />
                        </div>

                        @if ($settings->enable_withdrawal_otp)
                            <div class="mb-3 form-group">
                                <label>Enter OTP</label>
                                <div class="mb-1 float-end text-end">
                                    <a class="btn btn-primary btn-sm" href="" wire:click.prevent="requestOtp">
                                        <x-spinner wire:loading wire:target="requestOtp" />
                                        <i class="fa fa-envelope" wire:loading.remove wire:target="requestOtp">
                                        </i>
                                        Request OTP
                                    </a>
                                </div>
                                <x-form.input placeholder="Enter OTP" name="otp" required wire:model='otp' />
                                <small class="text-muted h6">OTP will be sent to your email address</small>
                            </div>
                        @endif
                        @if (!$method->default_pay || $method->name == 'BUSD')
                            @if ($method->methodtype == 'crypto')
                                <div class="mb-3 form-group">
                                    <label>Enter {{ $method->name }} Address </label>
                                    <x-form.input placeholder="Enter {{ $method->name }} Address" name="wallet_address"
                                        wire:model='wallet_address' required />
                                    <small class="h6">
                                        {{ $method->name }} is not a default
                                        withdrawal option in your account, please enter the correct
                                        wallet address to recieve your funds.
                                    </small>
                                </div>
                            @else
                                <div class="mb-3 form-group">
                                    <label>Enter {{ $method->name }} Details </label>
                                    <textarea class="form-control" row="4" name="details" wire:model='details'
                                        placeholder="BankName: Name, Account Number: Number, Account name: Name, Swift Code: Code">
                                    </textarea>
                                    <span class="text-muted h6">{{ $method->name }} is not a default
                                        withdrawal option in your account, please enter the correct bank
                                        details seperated by comma to recieve your funds.</span> <br />
                                    <small class="text-primary h6">
                                        BankName: Name, Account Number: Number,
                                        Account name: Name, Swift Code: Code
                                    </small>
                                </div>
                            @endif
                        @endif
                        <div class="mb-3 form-group">
                            <x-ui.button>
                                <x-spinner wire:loading wire:target="save" />
                                Complete Request
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
