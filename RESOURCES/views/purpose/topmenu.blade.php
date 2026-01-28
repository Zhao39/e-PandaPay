<!-- Main nav -->
<nav class="navbar navbar-main navbar-expand-lg navbar-dark bg-primary navbar-border" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand + Toggler (for mobile devices) -->
        <div class="pl-4 d-block d-md-none">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}"
                @if ($settings->spa_mode) wire:navigate @endif>
                <img src="{{ asset('storage/' . $settings->logo) }}" class="navbar-brand-img"
                    alt=" {{ $settings->site_name }}" width="{{ $settings->user_dashboard_logo_size }}">
            </a>
        </div>

        <!-- User's navbar -->
        <div class="ml-auto navbar-user d-lg-none">
            <ul class="flex-row navbar-nav align-items-center">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><i class="far fa-bars"></i></a>
                </li>

                @if ($settings->enable_kyc)
                    <li class="nav-item dropdown dropdown-animate">
                        @if (Auth::user()->account_verify == 'verified')
                            <a class="nav-link nav-link-icon" href="#">
                                <i class="fas fa-user-check"></i>
                                <strong style="font-size:8px;">Verified</strong>
                            </a>
                        @else
                            <a class="nav-link nav-link-icon" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                                <strong style="font-size:8px;">KYC</strong>
                            </a>
                            <div class="p-0 dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow">
                                <div class="p-2">
                                    <h5 class="mb-0 heading h6">KYC Verification</h5>
                                </div>
                                <div class="pb-2 mt-0 text-center list-group list-group-flush">
                                    @if (Auth::user()->account_verify == 'under review')
                                        Your Submission is under review
                                    @else
                                        <div class="">
                                            <a href="{{ route('user.kyc.start') }}" class="btn btn-primary btn-sm"
                                                @if ($settings->spa_mode) wire:navigate @endif>Verify
                                                Account </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </li>
                @endif

                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if (auth()->user()->profile_photo_path)
                            <div class="avatar rounded-circle">
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="..."
                                    class="border avatar-img rounded-circle">
                            </div>
                        @else
                            <span class="avatar rounded-circle">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="px-0 dropdown-header">Hi, {{ Auth::user()->name }}!</h6>
                        <a href="{{ route('user.profile.show') }}" class="dropdown-item"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-purpose').submit();">
                            <i class="far fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-purpose" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Navbar nav -->
        <div class="collapse navbar-collapse navbar-collapse-fade" id="navbar-main-collapse">
            <!-- Right menu -->
            <ul class="navbar-nav ml-lg-auto align-items-center d-none d-lg-flex">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><i class="far fa-bars"></i></a>
                </li>

                @if ($settings->enable_kyc)
                    <li class="nav-item dropdown dropdown-animate">
                        @if (Auth::user()->account_verify == 'verified')
                            <a class="nav-link nav-link-icon" href="#">
                                <i class="fas fa-user-check"></i>
                                <strong style="font-size:8px;">Verified</strong>
                            </a>
                        @else
                            <a class="nav-link nav-link-icon" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                                <strong style="font-size:8px;">KYC</strong>
                            </a>
                            <div class="p-0 dropdown-menu dropdown-menu-right dropdown-menu-lg dropdown-menu-arrow">
                                <div class="p-2">
                                    <h5 class="mb-0 heading h6">KYC Verification</h5>
                                </div>
                                <div class="pb-2 mt-0 text-center list-group list-group-flush">
                                    @if (Auth::user()->account_verify == 'under review')
                                        Your Submission is under review
                                    @else
                                        <div class="">
                                            <a href="{{ route('user.kyc.start') }}" class="btn btn-primary btn-sm"
                                                @if ($settings->spa_mode) wire:navigate @endif>Verify
                                                Account </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </li>
                @endif

                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media media-pill align-items-center">
                            @if (auth()->user()->profile_photo_path)
                                <div class="avatar rounded-circle">
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                        alt="..." class="border avatar-img rounded-circle">
                                </div>
                            @else
                                <span class="avatar rounded-circle">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                </span>
                            @endif
                            <div class="ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="px-0 dropdown-header">Hi, {{ Auth::user()->name }}!</h6>
                        <a href="{{ route('user.profile.show') }}" class="dropdown-item"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-userp').submit();">
                            <i class="far fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-userp" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
