<x-guest-layout>
    <x-slot:title>
        Forgot your password
    </x-slot:title>
    <div>
        @session('status')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession
        <!--begin::Form-->
        <form class="form w-100" method="POST" action="{{ route('password.email') }}">
            @csrf
            <!--begin::Heading-->
            <div class="mb-10 text-center">
                <!--begin::Title-->
                <h1 class="mb-3 text-dark fw-bolder">
                    Forgot Password ?
                </h1>
                <!--end::Title-->
                <!--begin::Link-->
                <div class="text-gray-500 fw-semibold fs-6">
                    Enter your email to reset your password.
                </div>
                <!--end::Link-->
            </div>
            <!--begin::Heading-->

            <!--begin::Input group--->
            <div class="row">
                <div class="mb-8 col-12">
                    <x-form.input type="text" placeholder="Email" name="email" required autofocus
                        autocomplete="username" />
                </div>
            </div>

            <!--begin::Actions-->
            <div class="flex-wrap d-flex justify-content-center pb-lg-0">
                <x-ui.button class="me-4">
                    Submit
                </x-ui.button>
                <x-ui.link href="{{ url('/login') }}" class="btn btn-light" label="Cancel" />
            </div>
            <!--end::Actions-->
        </form>
    </div>
</x-guest-layout>
