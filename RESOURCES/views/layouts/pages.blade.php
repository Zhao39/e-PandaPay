<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/png" />
    {{ $header }}
    <link href="{{ asset('front_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('front_assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Magnific -->
    <link rel="stylesheet" href="{{ asset('front_assets/css/line.css') }}">
    <link href="{{ asset('front_assets/css/flexslider.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front_assets/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />

    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('front_assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front_assets/css/owl.theme.default.min.css') }}" />
    <link href="{{ asset('front_assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Css -->
    @include('layouts.includes.color-front')
    @include('layouts.includes.color-front2')
    @include('layouts.includes.livechat')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{ $styles ?? '' }}
    @livewireStyles
</head>

<body>
    <!-- Navbar STart -->
    <header id="topnav" class="sticky defaultscroll nav-sticky">
        <div class="container">
            <!-- Logo container-->
            <div>
                <a class="logo" href="/" @if ($settings->spa_mode) wire:navigate @endif>
                    <img src="{{ asset('storage/' . $settings->logo) }}" width="{{ $settings->website_logo_size }}"
                        alt="" class="mr-2">
                </a>
            </div>
            @guest
                <div class="buy-button d-none d-lg-block">
                    <a href="register" @class([
                        'mr-3 btn btn-sm',
                        'login-btn-success btn-primary' => $settings->home_theme == 'home1',
                        'bg-primary text-white' => $settings->home_theme == 'home2',
                    ])>
                        <span style="font-size: 13px">Register</span>
                    </a>
                    <a href="login" @class([
                        'btn btn-sm',
                        'login-btn-success btn-primary' => $settings->home_theme == 'home1',
                        'btn-secondary bg-darken text-white' => $settings->home_theme == 'home2',
                    ])>
                        <span style="font-size: 13px">Login</span>
                    </a>
                </div>
            @endguest
            @auth
                <div class="buy-button">
                    <a href="{{ route('user.dashboard') }}" @class([
                        'btn btn-sm',
                        'btn-primary' => $settings->home_theme == 'home1',
                        'bg-primary text-white' => $settings->home_theme == 'home2',
                    ])>
                        <span style="font-size: 13px">
                            Dashboard
                            <i class="bi bi-box-arrow-in-right"></i>
                        </span>
                    </a>
                </div>
            @endauth
            <!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    @foreach ($pages as $page)
                        @if ($page->name === 'Home' || $page->name === 'About' || $page->name === 'Faq')
                            <li>
                                <a href="{{ route('home.' . $page->name) }}" @class([
                                    'text-darken' => $settings->home_theme == 'home2',
                                ])
                                    @if ($settings->spa_mode) wire:navigate @endif>{{ $page->link_name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @guest
                    <!--end navigation menu-->
                    <div class="pb-2 pl-4 buy-menu-btn d-block d-lg-none">
                        <a href="register" class="mr-3 btn btn-primary login-btn-success btn-sm">
                            <span style="font-size: 15px">Register</span>
                        </a>
                        <a href="login" class="btn btn-secondary login-btn-success btn-sm">
                            <span style="font-size: 15px">Login</span>
                        </a>
                    </div>
                    <!--end login button-->
                @endguest
                @auth
                    <div class="pb-2 pl-4 buy-menu-btn d-block d-lg-none ">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-sm">
                            <span style="font-size: 15px">Dashboard</span>
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                    </div>
                @endauth
            </div>
            <!--end navigation-->
        </div>
        <!--end container-->
    </header>

    <!--end header-->
    <!-- Navbar End -->
    {{ $slot }}

    <livewire:pages.footer />

    <!-- javascript -->
    <script src="{{ asset('front_assets/js/jquery-3.5.1.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>
    <script src="{{ asset('front_assets/js/bootstrap.bundle.min.js') }}"
        @if ($settings->spa_mode) data-navigate-once @endif></script>

    <!-- SLIDER -->
    <script src="{{ asset('front_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/owl.init.js') }}"></script>
    <script src="{{ asset('front_assets/js/app.js') }}"></script>
    <script src="{{ asset('front_assets/js/widget.js') }}" @if ($settings->spa_mode) data-navigate-once @endif>
    </script>

    @livewireScripts
    {{ $scripts ?? '' }}
</body>

</html>
