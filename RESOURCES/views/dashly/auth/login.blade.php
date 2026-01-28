@extends('layouts.dashly-guest')
@section('title', 'Login account')
@section('content')

    <div class="row align-items-center justify-content-center vh-100">
        <div class="py-6 shadow-sm col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3">
            @if (Session::has('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mb-3 text-center">
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo"
                        width="{{ $settings->auth_pages_logo_size }}">
                </a>
            </div>
            <!-- Title -->
            <h1 class="mb-2 text-center">
                Sign In
            </h1>

            <!-- Subtitle -->
            <p class="text-center text-secondary">
                Enter your email address and password to access your account.
            </p>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                            <!-- Label -->
                            <label class="form-label">
                                Email Address
                            </label>
                            <!-- Input -->
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="Your email address">
                            @error('email')
                                <small class="fs-6 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Password -->
                        <div class="mb-4">

                            <div class="row">
                                <div class="col">

                                    <!-- Label -->
                                    <label class="form-label">
                                        Password
                                    </label>
                                </div>

                                <div class="col-auto">

                                    <!-- Help text -->
                                    <a href="{{ route('password.request') }}"
                                        class="form-text small text-muted link-primary">Forgot password</a>
                                </div>
                            </div> <!-- / .row -->

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" autocomplete="off" data-toggle-password-input
                                    placeholder="Your password" name="password">

                                <button type="button" class="px-4 input-group-text text-secondary link-primary"
                                    data-toggle-password></button>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .row -->

                <div class="form-check">
                    <!-- Input -->
                    <input type="checkbox" class="form-check-input" name="remember">
                    <!-- Label -->
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <div class="text-center row align-items-center">
                    <div class="col-12">

                        <!-- Button -->
                        <button type="submit" class="mt-6 mb-2 btn w-100 btn-primary">Sign in</button>
                    </div>

                    <div class="col-12">

                        <!-- Link -->
                        <small class="mb-0 text-muted">Don't have an account yet? <a href="{{ route('register') }}"
                                class="fw-semibold">Sign up</a></small>
                    </div>
                </div> <!-- / .row -->
            </form>
            @if ($settings->enable_social_login)
                <div class="my-2 text-center">
                    <small>Or</small>
                    <div class="row">
                        <!--end col-->
                        <div class="my-3 col-12">
                            <a href="{{ route('social.redirect', ['social' => 'google']) }}" class="btn btn-sm btn-danger">
                                <i class="bi bi-google"></i> Sign in with
                                Google</a>
                        </div>
                        <!--end col-->
                    </div>
                </div>
            @endif
        </div>
    </div> <!-- / .row -->
@endsection
