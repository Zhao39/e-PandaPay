<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}" />
    <title>{{ $settings->site_name }} - {{ $title }}</title>
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="keywords" content="{{ $settings->keywords }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('themes/default/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('themes/default/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <!--end::Global Stylesheets Bundle-->
    @include('layouts.includes.auth-color')
    <!-- Styles -->
    @livewireStyles
</head>

<body id="kt_body" class="app-blank">
    <!--begin::Root-->
    <section style="height: 100vh; background:#e1f0f8">
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <!--begin::Body-->
                <div class=" d-flex flex-column flex-lg-row-fluid w-lg-50">
                    <!--begin::Form-->
                    <div class="p-3 d-flex flex-center flex-column flex-lg-row-fluid p-lg-0">
                        <!--begin::Wrapper-->
                        <div class="p-5 rounded shadow-sm p-lg-10 w-lg-500px" style="margin-top: 100px;">
                            <div class="mb-8 text-center">
                                <!--begin::Logo-->
                                <a href="/" class="mb-0 text-center mb-lg-20">
                                    <img alt="Logo" src="{{ asset('storage/' . $settings->logo) }}"
                                        width="{{ $settings->auth_pages_logo_size }}" />
                                </a>
                                <!--end::Logo-->
                            </div>
                            {{ $slot }}
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Authentication -->
        </div>
    </section>
    <!--end::Root-->
    @livewireScripts
    <script src="{{ asset('themes/default/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/custom/authentication/sign-in/general.js') }}"></script>
</body>

</html>
