<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title ?? '' }}</title>

    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/png" />
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('themes/purpose/libs/%40fortawesome/fontawesome-pro/css/all.min.css') }}">
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    @include('layouts.includes.purpose-color')
    {{-- <link rel="stylesheet" href="{{ asset('themes/purpose/css/purpose.css') }}" id="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('themes/purpose/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/purpose/libs/animate.css/animate.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('themes/purpose/libs/flatpickr/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
    <script src="{{ asset('themes/purpose/js/purpose.core.js') }}"></script>
    @include('layouts.includes.livechat')
    @stack('styles')
    @livewireStyles
</head>

<body class="purpose application-offset">
    <!-- Application container -->
    <div class="container-fluid container-application">
        {{-- Side Bar --}}
        @include('purpose.sidebar')
        <!-- Content -->
        <div class="main-content position-relative">
            <!-- Main nav -->
            @include('purpose.topmenu')

            <!-- Page content -->
            <div class="page-content">
                @yield('content')
            </div>
            <!-- Footer -->
            <div class="pt-5 pb-4 footer footer-light sticky-bottom" id="footer-main">
                <div class="text-center row text-sm-left align-items-sm-center">
                    <div class="col-sm-6">
                        <p class="mb-0 text-sm">All Rights Reserved &copy; {{ $settings->site_name }}
                            {{ date('Y') }}</p>
                    </div>
                    @if ($settings->enable_google_translate)
                        <div class="col-sm-6 ">
                            <div id="google_translate_element"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Purpose JS -->
    <script src="{{ asset('themes/purpose/js/purpose.js') }}"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script src="{{ asset('dash/js/millage.js') }}" @if ($settings->spa_mode) data-navigate-once @endif></script>
    @livewireScripts
    @stack('scripts')
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert2.all.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <x-livewire-alert::scripts />
</body>

</html>
