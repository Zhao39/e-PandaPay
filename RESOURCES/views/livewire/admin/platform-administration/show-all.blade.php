<x-slot:title>
    Platform Administration
</x-slot:title>
<div>
    <x-breadcrumbs title="Platform Administration">
        <li class="nav-item">
            <a href="#">Platform Administrations</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class=" font-weight-bolder">System</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('see administrators')
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-user-friends"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.admins') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Admin Settings</h5>
                                    </a>
                                    <small>View and update your system admins and their roles</small>
                                </div>
                            </div>
                        @endcan

                        @can('update roles & permissions')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-users"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.roles') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Roles And Permissions</h5>
                                    </a>
                                    <small>View and update your roles and permissions</small>
                                </div>
                            </div>
                        @endcan
                        @can('view activty log')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-file"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.activitiesLog') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Activities Log</h5>
                                    </a>
                                    <small>View and delete your system activity logs</small>
                                </div>
                            </div>
                        @endcan
                        @can('view cronjob')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.cron') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Cronjob</h5>
                                    </a>
                                    <small>Automate certain commands or scripts on your site.</small>
                                </div>
                            </div>
                        @endcan
                        @can('perform system cleanup')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-recycle"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.cleanUp') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">System Cleanup</h5>
                                    </a>
                                    <small>Cleanup your unused data in database</small>
                                </div>
                            </div>
                        @endcan
                        @can('clear cache')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-hdd"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.clearcache') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Cache Management/Symlink</h5>
                                    </a>
                                    <small>Clear cache to make your site up to date and run symlink</small>
                                </div>
                            </div>
                        @endcan
                        @can('view system info')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-laptop"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.systemInfo') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">System Information</h5>
                                    </a>
                                    <small>All information about current system configuration.</small>
                                </div>
                            </div>
                        @endcan
                        @can('perform system update')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light"><i class="fas fa-retweet"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.platform.systemUpdate') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">System Updater</h5>
                                    </a>
                                    <small>Check for updates on upcoming versions</small>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
