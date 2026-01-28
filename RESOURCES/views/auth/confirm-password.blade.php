<x-guest-layout>
    <x-slot:title>
        Confirm password
    </x-slot:title>
    <div>
        <!--begin::Form-->
        <form method="POST" class="form w-100" action="{{ route('password.confirm') }}">
            @csrf
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <h1 class="mb-3 h5 text-dark fw-bolder">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </h1>
            </div>
            <div class="row">
                <div class="mb-8 col-12">
                    <x-form.input type="password" placeholder="Enter your password" name="password" required
                        autocomplete="current-password" />
                </div>
            </div>
            <!--begin::Submit button-->
            <div class="mb-10 d-grid">
                <x-ui.button>
                    Confirm
                </x-ui.button>
            </div>
            <!--end::Submit button-->
        </form>
        <!--end::Form-->
    </div>
</x-guest-layout>
