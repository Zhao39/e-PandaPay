@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <div>
        <!-- Title -->
        <h1 class="m-0 h2">
            Transfer funds
        </h1>
        <p class="m-0">You can send money to your friends and loved ones registered on {{ $settings->site_name }}.</p>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            @if ($show_password)
                                <form wire:submit="transfer">
                                @else
                                    <form wire:submit="$set('show_password', true)">
                            @endif

                            <div class="mb-3">
                                <label class="mb-2">
                                    Recipient Email or username
                                    <span class=" text-danger">*</span>
                                </label>
                                <x-form.input name="email" wire:model='email' required />
                            </div>
                            <div class="mb-3">
                                <label class="mb-2">
                                    Amount({{ $settings->currency }})
                                    <span class="text-danger">*</span>
                                </label>
                                <x-form.input type="number" wire:model='amount' min="{{ $settings->min_transfer }}"
                                    name="amount" placeholder="Enter amount you want to transfer to recipient"
                                    required />
                            </div>
                            @if ($show_password)
                                <div class="mb-3">
                                    <label class="mb-2">
                                        Enter your Password
                                    </label>
                                    <x-form.input type="password" wire:model='password' name="password"
                                        placeholder="Enter your password" :required="$show_password" />
                                </div>
                            @endif
                            <div class="mb-3">
                                <h6>Transfer Charges:
                                    <strong class="text-danger">
                                        {{ Number::percentage($settings->transfer_charges) }}
                                    </strong>
                                </h6>
                            </div>
                            <div class="mb-3">
                                @if ($show_password)
                                    <x-ui.button>
                                        <x-spinner wire:loading wire:target="transfer" />
                                        Complete Transfer
                                    </x-ui.button>
                                    <x-ui.button type="button" class="btn-secondary" wire:click='cancel'>
                                        <x-spinner wire:loading wire:target="cancel" />
                                        Cancel
                                    </x-ui.button>
                                @else
                                    <x-ui.button>
                                        <x-spinner wire:loading wire:target="show_password" />
                                        Transfer Now
                                    </x-ui.button>
                                @endif

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
