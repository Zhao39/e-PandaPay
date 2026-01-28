<x-slot:title>
    Admin Sign in
</x-slot:title>
<div>
    <x-alert />
    <!--begin::Form-->
    <form method="POST" class="form w-100" wire:submit='store'>
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <h1 class="mb-3 text-dark fw-bolder">
                Admin Sign In
            </h1>
        </div>

        <div class="row">
            <div class="mb-8 col-12">
                <x-form.input type="email" placeholder="Email" value="{{ old('email') }}" name="email" required
                    autofocus autocomplete="username" wire:model='email' />
            </div>
            <div class="mb-8 col-12 position-relative" data-kt-password-meter="true">
                <x-form.input type="password" placeholder="Password" name="password" required
                    autocomplete="current-password" wire:model='password' />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                    data-kt-password-meter-control="visibility">
                    <i class="ki-duotone bi-eye fs-2"></i>
                    <i class="ki-duotone bi-eye-slash fs-2 d-none"></i>
                </span>
            </div>
        </div>
        <div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold">
            <div></div>
            <x-ui.link href="{{ route('admin.auth.forgotPassword') }}" label="Forgot Password ?" />
        </div>

        <!--begin::Submit button-->
        <div class="mb-10 d-grid" x-data="{ ready: false }" x-init="document.addEventListener('livewire:initialized', () => {
            ready = true;
        })">
            <x-ui.button ::disabled="!ready">
                <span class="indicator-label" wire:loading.remove>
                    Sign In
                </span>
                <span class="indicator-progress" wire:loading>
                    Please wait... <span class="align-middle spinner-border spinner-border-sm ms-2"></span>
                </span>
            </x-ui.button>
        </div>
        <!--end::Submit button-->
    </form>
    <!--end::Form-->
</div>
