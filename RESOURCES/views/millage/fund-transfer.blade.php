@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Fund Transfer" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Fund Transfer</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    @if ($show_password)
                        <form wire:submit="transfer">
                        @else
                            <form wire:submit="$set('show_password', true)">
                    @endif

                    <div class="form-group">
                        <label>
                            Recipient Email or username
                            <span class=" text-danger">*</span>
                        </label>
                        <x-form.input name="email" wire:model='email' required />
                    </div>
                    <div class="form-group">
                        <label>
                            Amount({{ $settings->currency }})
                            <span class="text-danger">*</span>
                        </label>
                        <x-form.input type="number" wire:model='amount' min="{{ $settings->min_transfer }}"
                            name="amount" placeholder="Enter amount you want to transfer to recipient" required />
                    </div>
                    @if ($show_password)
                        <div class="form-group">
                            <label>
                                Enter your Password
                            </label>
                            <x-form.input type="password" wire:model='password' name="password"
                                placeholder="Enter your password" :required="$show_password" />
                        </div>
                    @endif
                    <div class="form-group">
                        <h6>Transfer Charges:
                            <strong class="text-danger">
                                {{ Number::percentage($settings->transfer_charges) }}
                            </strong>
                        </h6>
                    </div>
                    <div class="form-group">
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
