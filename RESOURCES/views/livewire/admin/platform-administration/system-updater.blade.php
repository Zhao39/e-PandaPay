<x-slot:title>
    System Updater
</x-slot:title>
<div>
    <x-breadcrumbs title="System Updater">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Platform Administration
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">System Updater</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Important Information!</h4>
                <ul>
                    <li>Please back up your database and script files before upgrading.</li>
                    <li>
                        Updating your webiste wil not modify or reset your data - it just reinstall the latest version
                        of the system.
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Update System</h5>
                    @if ($hasUpdate)
                        <h5 class="text-success">UPDATE IS AVAILABLE!!</h5>
                    @endif
                </div>
                <div class="card-body">
                    <x-ui.button type="button" class="btn-primary btn-sm" wire:click='checkVersion'
                        wire:loading.attr='disabled'>
                        <x-spinner wire:loading wire:target='checkVersion' />
                        <span wire:loading wire:target='checkVersion'> Checking</span>
                        <span wire:loading.remove wire:target='checkVersion'> Check for update</span>
                    </x-ui.button>
                    @if ($hasUpdate)
                        <a href="https://getonlinetrader.pro/login" target="_blank" class="btn btn-success btn-sm">
                            Download Update
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
