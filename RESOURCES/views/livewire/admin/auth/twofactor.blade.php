<x-slot:title>
    Two Factor Authentication
</x-slot:title>
<div>
    <x-alert />
    <!--begin::Form-->
    <form class="form w-100" wire:submit='authorizeWithTwofa'>
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <h1 class="mb-3 text-dark fw-bolder">
                Two Factor Authentication
            </h1>
        </div>

        <div class="row">
            <div class="mb-8 col-12">
                <label>Enter the code sent to your email address</label>
                <x-form.input type="number" placeholder="Enter Code" name="admin_two_factor_code" required
                    wire:model='admin_two_factor_code' />
                <x-form.input type="hidden" name="token_2fa_expiry" wire:model='token_2fa_expiry' />
            </div>
        </div>

        <!--begin::Submit button-->
        <div class="mb-10 d-grid">
            <x-ui.button>
                <span class="indicator-label" wire:loading.remove>
                    Continue
                </span>
                <span class="indicator-progress" wire:loading>
                    Please wait... <span class="align-middle spinner-border spinner-border-sm ms-2"></span>
                </span>
            </x-ui.button>
        </div>
        <!--end::Submit button-->
    </form>
    <div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold" x-data>
        <div></div>
        <form wire:submit='logout'>
            <button class="btn btn-link">Logout</button>
        </form>
    </div>
    <!--end::Form-->
</div>
