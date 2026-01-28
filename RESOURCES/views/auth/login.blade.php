<x-guest-layout>
    <x-slot:title>
        Sign in
    </x-slot:title>
    <div>
        @session('status')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession
        <!--begin::Form-->
        <form method="POST" class="form w-100" action="{{ route('login') }}">
            @csrf
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <h1 class="mb-3 text-dark fw-bolder">
                    Sign In
                </h1>
            </div>
            <!--begin::Heading-->
            @if ($settings->enable_social_login)
                @include('auth.social')
            @endif

            <div class="row">
                <div class="mb-8 col-12">
                    <x-form.input type="text" placeholder="Email or Username" value="{{ old('email') }}"
                        name="email" required autofocus autocomplete="username" />
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
                <!--begin::Accept-->
                <div class="mb-8 col-12">
                    <label class="form-check form-check-inline">
                        <x-checkbox class="form-check-input" type="checkbox" name="remember" />
                        <span class="text-gray-700 form-check-label fw-semibold fs-base ms-1">
                            {{ __('Remember me') }}</a>
                        </span>
                    </label>
                </div>
                <!--end::Accept-->
            </div>

            @if (Route::has('password.request'))
                <div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold">
                    <div></div>
                    <x-ui.link href="{{ route('password.request') }}" label="Forgot Password ?" />
                </div>
            @endif

            <!--begin::Submit button-->
            <div class="mb-10 d-grid">
                <x-ui.button>
                    <span class="indicator-label">
                        Sign In
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="align-middle spinner-border spinner-border-sm ms-2"></span>
                    </span>
                </x-ui.button>
            </div>
            <!--end::Submit button-->

            <!--begin::Sign up-->
            <div class="text-center text-gray-500 fw-semibold fs-6">
                Not a Member yet?
                <x-ui.link href="{{ url('/register') }}" label="Sign up" />
            </div>
        </form>
        <!--end::Form-->
    </div>
</x-guest-layout>
