<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}" />
    <title>{{ $settings->site_name }} - {{ $title }}</title>
    <meta name="description" content="{{ $settings->site_title }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <link href="{{ asset('themes/default/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('themes/default/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    @include('layouts.includes.auth-color')
    @livewireStyles
</head>

<body id="kt_body" class="app-blank">

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center"
                style="background: {{ $auth2->img_path }}">
                <!--begin::Content-->
                <div class="p-6 d-flex flex-column flex-center p-lg-10 w-100">
                    <!--begin::Logo-->
                    <a href="/" class="mb-0 mb-lg-20">
                        <img alt="Logo" src="{{ asset('storage/' . $settings->logo) }}"
                            width="{{ $settings->auth_pages_logo_size }}" />
                    </a>
                    <!--end::Logo-->
                    @if ($auth->img_path)
                        <!--begin::Image-->
                        <img class="mx-auto mb-10 d-none d-lg-block w-300px w-lg-75 w-xl-500px mb-lg-20"
                            src="{{ asset('storage/' . $auth->img_path) }}" alt="  {{ $auth->title }}" />
                        <!--end::Image-->
                    @endif

                    <!--begin::Title-->
                    <h1 class="text-center d-none d-lg-block fs-2qx fw-bold mb-7">
                        {{ $auth->title }}
                    </h1>
                    <!--end::Title-->

                    <!--begin::Text-->
                    <div class="text-center d-none d-lg-block fs-base">
                        {{ $auth->description }}
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>
            <!--begin::Aside-->

            <!--begin::Body-->
            <div class=" d-flex flex-column flex-lg-row-fluid w-lg-50">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="p-10 w-lg-500px">
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
    <!--end::Root-->

    @livewireScripts
    <script src="{{ asset('themes/default/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('themes/default/js/custom/authentication/sign-in/general.js') }}"></script>
</body>

</html>
