<x-slot:title>
    Forgot your password
</x-slot:title>
<div>
    <x-alert />
    <!--begin::Form-->
    <form method="POST" class="form w-100" wire:submit='sendPasswordRequest'>
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <h1 class="mb-3 text-dark fw-bolder">
                Forgot your password
            </h1>
            <div class="fw-semibold fs-6">
                Enter your email to reset your password.
            </div>
        </div>

        <div class="row">
            <div class="mb-8 col-12">
                <x-form.input type="email" placeholder="Email" value="{{ old('email') }}" name="email" required
                    autofocus autocomplete="username" wire:model='email' />
            </div>
        </div>

        <!--begin::Actions-->
        <div class="flex-wrap d-flex justify-content-center pb-lg-0">
            <x-ui.button class="me-4">
                Submit
            </x-ui.button>
            <x-ui.link href="{{ route('admin.auth.login') }}" class="btn btn-light" label="Cancel" />
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
</div>
