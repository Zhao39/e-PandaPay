<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">
        <a href="/" class="text-center logo">
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo not found"
                width="{{ $settings->admin_dashboard_logo_size }}">
        </a>
        <button class="ml-auto navbar-toggler" type="button" data-toggle="collapse" data-target="collapse"
            aria-expanded="false" aria-label="Toggle navigation" @click="nav_open = !nav_open">
            <span class="navbar-toggler-icon">
                <i class="bi bi-list "></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical "></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="bi bi-list "></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue">
        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <a href="{{ route('admin.users.listUsers') }}" @if ($settings->spa_mode) wire:navigate @endif>
                    <form class="navbar-left navbar-form nav-search mr-md-3" action="javascript:void(0)">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="pr-1 btn btn-search">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input type="text" placeholder="Manage users" class="form-control ">
                        </div>
                    </form>
                </a>
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a href="javascript:void(0)" class="text-white" onclick="toggleMode()">
                        <i class="bi bi-brightness-high-fill dark-icon" style="font-size: 25px;"></i>
                        <i class="bi bi-moon-fill light-icon d-none" style="font-size: 25px;"></i>
                    </a>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                alt="..." class="border avatar-img rounded-circle border-light">
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
                                @can('admin update account settings')
                                    <a class="dropdown-item" href="{{ route('admin.accountSettings') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <i class="bi bi-person-fill-gear text-primary"></i>
                                        Account Settings
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endcan
                                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" x-data>
                                    @csrf
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item"
                                        @click.prevent="localStorage.removeItem('alertDismissed');$root.submit();">
                                        <i class="bi bi-box-arrow-right text-danger"></i>
                                        {{ __('Log Out') }}
                                    </a>
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
