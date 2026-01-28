<x-slot:title>
    System Information
</x-slot:title>
<div>
    <x-breadcrumbs title="System Information">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Platform Administration
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">System Information</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <h5 class="font-weight-bold">System Environment</h5>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p>Software Version</p>
                        <p class="font-weight-bold">v{{ $settings->software_version }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Framework Version</p>
                        <p class="font-weight-bold">v{{ Illuminate\Foundation\Application::VERSION }} </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>PHP Version</p>
                        <p class="font-weight-bold">v{{ PHP_VERSION }} </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Timezone</p>
                        <p class="font-weight-bold">{{ config('app.timezone') }} </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Debug Mode</p>
                        <p class="font-weight-bold">
                            @if (!config('app.debug'))
                                Off
                                <i class="bi bi-check-circle text-success"></i>
                            @else
                                On
                                <i class="bi bi-info-circle text-danger"></i>
                            @endif
                        </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Database</p>
                        <p class="font-weight-bold">{{ config('database.default') }} </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>SSL Installed</p>
                        <p class="font-weight-bold">
                            @if ($hasSSL)
                                Installed
                                <i class="bi bi-check-circle text-success"></i>
                            @else
                                Not Installed
                                <i class="bi bi-info-circle text-danger"></i>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
