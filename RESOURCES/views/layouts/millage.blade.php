<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{
    nav_open: false
}" x-bind:class="nav_open ? 'nav_open' : ''">

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title ?? '' }}</title>
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/png" />
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <!-- Fonts and icons -->
    <script src="{{ asset('dash/js/plugin/webfont/webfont.min.js') }}"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/fonts.min.css') }}">
    @include('layouts.includes.color')
    @include('layouts.includes.livechat')
    <link rel="stylesheet" href="{{ asset('dash/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        body[data-background-color="dark"] {
            color: #f0f0f0 important;
        }

        body[data-background-color="dark"] .card-body {
            color: #f0f0f0 important;
        }

        /* any text inside a table class should have color white in dark mode */
        body[data-background-color="dark"] .table {
            color: #f0f0f0;
        }

        .modal-content[data-background-color="dark"] {
            background-color: #1a2035;
        }

        body[data-background-color="dark"] .table-hover {
            color: #f0f0f0 important;
        }
    </style>
    @stack('styles')
    @livewireStyles
    <script>
        console.log('Hello');
    </script>
</head>

<body data-background-color="light">
    <div class="wrapper">
        @include('millage.topmenu')
        @include('millage.sidebar')
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div @class([
                    'text-center' => !$settings->enable_google_translate,
                    'd-flex justify-content-between align-items-center' =>
                        $settings->enable_google_translate,
                ])>
                    <p>All Rights Reserved &copy; {{ $settings->site_name }} {{ date('Y') }}</p> <br>
                    @if ($settings->enable_google_translate)
                        <div class="text-center">
                            <div id="google_translate_element"></div>
                        </div>
                    @endif
                </div>
            </footer>
        </div>
        <script>
            function setTheme() {
                console.log('Hello');
                const savedMode = localStorage.getItem('background-color');
                const darkIcon = document.querySelector('.dark-icon');
                const lightIcon = document.querySelector('.light-icon');
                const modal = document.querySelector('.modal-content');
                console.log(modal);
                // get all element with class of .bg-light
                const lightbg = document.querySelectorAll('.bg-light');
                const transbg = document.querySelectorAll('.bg-drk-trans');
                console.log(savedMode);
                if (savedMode) {
                    if (savedMode === 'dark') {
                        darkIcon.classList.remove('d-none');
                        lightIcon.classList.add('d-none');
                        if (lightbg) {
                            lightbg.forEach(element => {
                                element.classList.remove('bg-light');
                            });
                        }
                    } else {
                        lightIcon.classList.remove('d-none');
                        darkIcon.classList.add('d-none');
                        if (transbg) {
                            transbg.forEach(element => {
                                element.classList.add('bg-light');
                            });
                        }
                    }
                    document.body.setAttribute('data-background-color', savedMode);
                    document.querySelector('.sidebar-style-2').setAttribute('data-background-color', savedMode);
                    if (modal) {
                        modal.setAttribute('data-background-color', savedMode);
                    }
                }
            }
            setTheme();
        </script>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('dash/js/core/popper.min.js') }}" @if ($settings->spa_mode) data-navigate-once @endif>
    </script>
    <script src="{{ asset('dash/js/core/bootstrap.min.js') }} "
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('dash/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('dash/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }} "
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('dash/js/customs.js') }}" @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('dash/js/millage.js') }}" @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('dash/js/core/index.js') }}"></script>
    @livewireScripts
    @stack('scripts')
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert2.all.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <x-livewire-alert::scripts />
    <script>
        document.addEventListener('livewire:navigated', () => {
            $("html").removeClass("nav_open")
        })
    </script>
</body>

</html>
