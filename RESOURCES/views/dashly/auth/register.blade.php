@extends('layouts.dashly-guest')
@section('title', 'Sign up')
@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="py-6 col-md-7 col-lg-6 px-lg-4 px-xl-8 d-flex flex-column vh-100">
            @if (Session::has('status'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="/" class="mb-4 navbar-brand">
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo"
                    width="{{ $settings->auth_pages_logo_size }}">
            </a>

            <div>
                <!-- Title -->
                <h1 class="mb-2">
                    Sign Up
                </h1>

                <!-- Subtitle -->
                <p class="text-secondary">
                    Don't have an account? Create your account, it takes less than a minute
                </p>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <x-honeypot />
                    <div class="row" x-data="{
                        inputText: '',
                        handleClick() {
                            this.inputText = this.inputText.replace(/\s/g, '');
                        }
                    }">
                        <div class="mb-4 col-lg-6">
                            <label>Username</label>
                            <x-form.input type="text" x-model="inputText" placeholder="Enter Unique Username"
                                @keyup="handleClick()" name="username" value="{{ old('username') }}" required autofocus />
                        </div>

                        <div class="mb-4 col-lg-6">
                            <label class="form-label">
                                Full name
                            </label>
                            <x-form.input type="text" placeholder="Fullname" value="{{ old('name') }}" name="name"
                                required autofocus />
                        </div>

                        <div class="mb-4 col-lg-6">
                            <label class="form-label">
                                Email
                            </label>
                            <x-form.input type="email" placeholder="Email Address" value="{{ old('email') }}"
                                name="email" required autofocus />
                        </div>
                        <div class="mb-4 col-lg-6">
                            <!-- Label -->
                            <label class="form-label">
                                Phone Number
                            </label>
                            <x-form.input type="tel" placeholder="Phone Number" value="{{ old('phone_number') }}"
                                name="phone_number" required autofocus />
                        </div>
                        <div class="mb-4 col-lg-6">
                            <!-- Label -->
                            <label class="form-label">
                                Country
                            </label>
                            <select class="form-select" name="country" required>
                                <option selected disabled>Choose Country</option>
                                @include('dashly.auth.countries')
                            </select>
                            @error('country')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (Session::has('ref_by'))
                            <div class="mb-4 col-md-6">
                                <!-- Label -->
                                <label class="form-label">
                                    Referral ID
                                </label>
                                <x-form.input type="text" placeholder="Referral ID" value="{{ session('ref_by') }}"
                                    name="refferal" readonly />
                            </div>
                        @else
                            <div class="mb-4 col-md-6">
                                <!-- Label -->
                                <label class="form-label">
                                    Referral ID (Optional)
                                </label>
                                <x-form.input type="text" placeholder="Referral ID (optional)" name="refferal"
                                    autofocus />
                            </div>
                        @endif
                    </div> <!-- / .row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Password
                                </label>

                                <!-- Input -->
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" autocomplete="off"
                                        data-toggle-password-input placeholder="Your password" name="password" required>

                                    <button type="button" class="px-4 input-group-text text-secondary link-primary"
                                        data-toggle-password></button>
                                </div>
                            </div>
                            @error('password')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Confirm password
                                </label>
                                <!-- Input -->
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" autocomplete="off"
                                        data-toggle-password-input placeholder="Your password again"
                                        name="password_confirmation" required>

                                    <button type="button" class="px-4 input-group-text text-secondary link-primary"
                                        data-toggle-password></button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- / .row -->
                    @if ($settings->use_terms)
                        <div class="form-check">
                            <!-- Input -->
                            <input type="checkbox" class="form-check-input" id="agree" required>
                            <!-- Label -->
                            <label class="form-check-label" for="agree">
                                I agree with <a href="{{ route('home.Terms') }}">Terms & Conditions</a> and have
                                understood
                                <a href="javascript: void(0);">Privacy Policy</a>
                            </label>
                        </div>
                    @endif

                    <!-- Button -->
                    <button type="submit" class="mt-3 btn btn-primary">
                        Get started
                    </button>
                </form>
                @if ($settings->enable_social_login)
                    <div class="my-2 text-center">
                        <small>Or</small>
                        <div class="row">
                            <!--end col-->
                            <div class="my-3 col-12">
                                <a href="{{ route('social.redirect', ['social' => 'google']) }}"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-google"></i> Sign up with
                                    Google</a>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                @endif
            </div>

            <div class="pb-4 mt-auto">
                <!-- Link -->
                <small class="mb-0 text-muted">
                    Already registered? <a href="{{ route('login') }}" class="fw-semibold">Login</a>
                </small>
            </div>
        </div>

        <div class="col-md-5 col-lg-6 d-none d-lg-block">
            <!-- Image -->
            <div class="bg-size-cover bg-position-center bg-repeat-no-repeat overlay overlay-dark overlay-50 vh-100 me-n4"
                style="background-image: url({{ asset('storage/' . $auth2->img_path) }})"></div>
        </div>
    </div> <!-- / .row -->
@endsection
