<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">
        <a href="{{ url('user/dashboard') }}" class="logo">
            <img src="{{ asset('storage/' . $settings->logo) }}" alt=" {{ $settings->site_name }}"
                width="{{ $settings->user_dashboard_logo_size }}">
        </a>
        <button class="ml-auto navbar-toggler sidenav-toggler" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu "></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu "></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue">
        <div class="container-fluid">
            <div class="collapse" id="search-nav">
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a href="javascript:void(0)" class="text-white" onclick="toggleMode()">
                        <i class="bi bi-brightness-high-fill dark-icon" style="font-size: 25px;"></i>
                        <i class="bi bi-moon-fill light-icon d-none" style="font-size: 25px;"></i>
                    </a>
                </li>
                @if ($settings->enable_kyc)
                    <li class="nav-item dropdown hidden-caret">
                        @if (Auth::user()->account_verify == 'verified')
                            <a class="nav-link" href="#">
                                <i class="bi bi-person-check-fill"></i>
                                <strong style="font-size:8px;" class="text-success">Verified</strong>
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
                                        <small style="font-size: 10px">Your Account is under review</small>
                                    @else
                                        <div>
                                            <a href="{{ route('user.kyc.start') }}" class="btn btn-primary btn-sm"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                Verify Account
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </li>
                @endif
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                alt="..." class="border avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                            alt="image profile" class="rounded avatar-img">
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ auth()->user()->name }}</h4>
                                        <p class="text-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile.show') }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>Account
                                    Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-user').submit();">
                                    Logout
                                </a>
                                <form id="logout-user" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
