<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}" />
    <title>{{ $settings->site_name }} - Verify email</title>
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="keywords" content="{{ $settings->keywords }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('themes/default/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('themes/default/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    @include('layouts.includes.auth-color')
    <!--end::Global Stylesheets Bundle-->
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    {{-- @include('layouts.include.theme') --}}

    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="p-10 text-center d-flex flex-column flex-center">
                <!--begin::Wrapper-->
                <div class="py-5 shadow-sm card card-flush w-lg-650px">
                    <div class="card-body py-15 py-lg-20">
                        <!--begin::Logo-->
                        <div class="mb-14">
                            <a href="/" class="">
                                <img alt="Logo" src="{{ asset('storage/' . $settings->logo) }}" class="h-40px" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                            </div>
                        @endif

                        <!--begin::Title-->
                        <h1 class="mb-5 text-gray-900 fw-bolder">
                            Verify your email
                        </h1>
                        <!--end::Title-->

                        <!--begin::Action-->
                        <div class="mb-8 fs-6">
                            <span class="text-gray-500 fw-semibold">Did’t receive an email?</span>
                        </div>

                        <div class="mb-11">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <x-ui.button class="btn-sm">
                                    Resend Email
                                </x-ui.button>
                            </form>
                        </div>

                        <div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-ui.button class="btn-sm btn-danger">
                                    {{ __('Log Out') }}
                                </x-ui.button>

                            </form>
                        </div>

                        <!--end::Action-->

                        <!--begin::Illustration-->
                        <div class="mb-0">
                            <img src="{{ asset('themes/default/media/auth/verify-email.png') }}"
                                class="mw-100 mh-300px theme-light-show" alt="" />
                            <img src="{{ asset('themes/default/media/auth/verify-email-dark.png') }}"
                                class="mw-100 mh-300px theme-dark-show" alt="" />
                        </div>
                        <!--end::Illustration-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
    <!--end::Root-->

    <script src="{{ asset('themes/default/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/custom/authentication/sign-in/general.js') }}"></script>
</body>

</html>
