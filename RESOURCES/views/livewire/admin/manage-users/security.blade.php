<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit='resetPassword'>
                <div class="form-row">
                    <div class="mb-3 col-lg-6">
                        <label>Enter New Password</label>
                        <x-form.input type="password" name="password" wire:model='password' required />
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label>Confirm New Password</label>
                        <x-form.input type="password" name="password_confirmation" wire:model='password_confirmation'
                            required />
                    </div>
                    <div class="col-lg-12">
                        <x-ui.button>
                            Submit
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="m-0 font-weight-bold">Two Factor Authentication</h5>
            <small>
                You can turn off {{ $user->name }} Two Factor Authentication when they lost their 2FA device and could
                not access their account.
            </small>
            <div class="mt-3" x-data="{ areYouSure: false }">
                @if ($twoFfaIsOn)
                    <x-ui.button x-show="!areYouSure" @click="areYouSure = true" type="button" class="btn-warning">Turn
                        Off</x-ui.button>
                    <div x-show="areYouSure" style="display: none">
                        <h4 class="text-danger">Are you sure you want to perform this action.</h4>
                        <x-ui.button @click="areYouSure = false" type="button">Cancel</x-ui.button>
                        <x-ui.button @click="areYouSure = false" wire:click='turnOff2fa' type="button"
                            class="btn-danger">Confirm</x-ui.button>
                    </div>
                @else
                    <h4 class="text-danger font-weight-bold">{{ $user->name }} Two Factor Authentication is Off. </h4>
                    <p>You can turn it off when they turn it on</p>
                @endif
            </div>
        </div>
    </div>
</div>
