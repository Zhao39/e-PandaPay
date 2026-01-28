<x-guest-layout>
    <x-slot:title>
        Register account
    </x-slot:title>
    <div>
        <!--begin::Form-->
        <form class="form w-100" method="POST" action="{{ route('register') }}">
            @csrf
            <x-honeypot />
            <!--begin::Heading-->
            <div class="text-center mb-11">
                <h1 class="mb-3 text-dark fw-bolder">
                    Sign Up
                </h1>
            </div>
            <!--begin::Heading-->
            @if ($settings->enable_social_login)
                @include('auth.social')
            @endif

            <div class="row" x-data="{
                inputText: '',
                handleClick() {
                    this.inputText = this.inputText.replace(/\s/g, '');
                }
            }">
                <div class="mb-8 col-12">
                    <x-form.input type="text" x-model="inputText" placeholder="Enter Unique Username"
                        @keyup="handleClick()" name="username" value="{{ old('username') }}" required autofocus />
                </div>
                <div class="mb-8 col-12">
                    <x-form.input type="text" placeholder="Fullname" value="{{ old('name') }}" name="name"
                        required autofocus />
                </div>
                <div class="mb-8 col-12">
                    <x-form.input type="email" placeholder="Email Address" value="{{ old('email') }}" name="email"
                        required autofocus />
                </div>

                <div class="mb-8 col-12">
                    <x-form.input type="tel" placeholder="Phone Number" value="{{ old('phone_number') }}"
                        name="phone_number" required autofocus />
                </div>

                <div class="mb-8 col-lg-6">
                    <select name="country" class="form-select">
                        <option selected disabled>Choose Country</option>
                        @include('auth.countries')
                    </select>
                    <div>
                        @error('country')
                            <small class="text-xs text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @if (session('ref_by'))
                    <div class="mb-8 col-lg-6">
                        <x-form.input type="text" placeholder="Referral ID" value="{{ session('ref_by') }}"
                            name="refferal" readonly />
                        <small style="font-size: 6px">Referral ID</small>
                    </div>
                @else
                    <div class="mb-8 col-lg-6">
                        <x-form.input type="text" placeholder="Referral ID (optional)" name="refferal" autofocus />
                    </div>
                @endif
                <!--begin::Input group-->
                <div class="mb-8 col-12" data-kt-password-meter="true">
                    <!--begin::Wrapper-->
                    <div class="mb-1">
                        <!--begin::Input wrapper-->
                        <div class="mb-3 position-relative">
                            <x-form.input type="password" placeholder="Password" name="password" required
                                autocomplete="new-password" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="ki-duotone bi-eye fs-2"></i>
                                <i class="ki-duotone bi-eye-slash fs-2 d-none"></i>
                            </span>
                        </div>
                        <!--end::Input wrapper-->

                        <!--begin::Meter-->
                        <div class="mb-3 d-flex align-items-center" data-kt-password-meter-control="highlight">
                            <div class="rounded flex-grow-1 bg-secondary bg-active-success h-5px me-2">
                            </div>
                            <div class="rounded flex-grow-1 bg-secondary bg-active-success h-5px me-2">
                            </div>
                            <div class="rounded flex-grow-1 bg-secondary bg-active-success h-5px me-2">
                            </div>
                            <div class="rounded flex-grow-1 bg-secondary bg-active-success h-5px"></div>
                        </div>
                        <!--end::Meter-->
                    </div>

                    <div class="text-muted">
                        Use 8 or more characters with a mix of letters, numbers & symbols.
                    </div>
                    <!--end::Hint-->
                </div>
                <div class="mb-8 col-12">
                    <x-form.input type="password" placeholder="Repeat Password" name="password_confirmation" required
                        autocomplete="new-password" />
                </div>
                @if ($settings->use_terms)
                    <!--begin::Accept-->
                    <div class="mb-8 col-12">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="1" required />
                            <span class="text-gray-700 form-check-label fw-semibold fs-base ms-1">
                                I Accept the <a href="{{ route('home.Terms') }}" class="ms-1 link-primary">Terms &
                                    Conditions</a>
                            </span>
                        </label>
                    </div>
                    <!--end::Accept-->
                @endif

            </div>

            <!--begin::Actions-->
            <div class="mb-10 d-grid">
                <x-ui.button>
                    <span class="indicator-label">
                        Sign up
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="align-middle spinner-border spinner-border-sm ms-2"></span>
                    </span>
                </x-ui.button>
            </div>
            <!--end::Actions-->
            <div class="text-center text-gray-500 fw-semibold fs-6">
                Already have an Account?

                <a href="{{ route('login') }}" class="link-primary fw-semibold">
                    Sign in
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
