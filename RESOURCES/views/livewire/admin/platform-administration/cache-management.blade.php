<x-slot:title>
    Cache Management
</x-slot:title>
<div>
    <x-breadcrumbs title="Cache Management">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Platform Administration
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Cache Management</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    @if (config('app.env') == 'production')
                                        Optimize files on production
                                    @else
                                        Clear optimization files on local environment
                                    @endif
                                </td>
                                <td>
                                    @if (config('app.env') == 'production')
                                        <x-ui.button type="button" class="btn-sm" wire:click="optiimize('cache')">
                                            <x-spinner wire:loading wire:target="optiimize('cache')" />
                                            Optimize
                                        </x-ui.button>
                                    @else
                                        <x-ui.button type="button" class="btn-sm" wire:click="optiimize('clear')">
                                            <x-spinner wire:loading wire:target="optiimize('clear')" />
                                            Clear optimization
                                        </x-ui.button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Clear system cached data.</td>
                                <td>
                                    <x-ui.button type="button" class="btn-sm" wire:click="clearCache('cache')">
                                        <x-spinner wire:loading wire:target="clearCache('cache')" />
                                        Clear cache
                                    </x-ui.button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Clear system log files
                                </td>
                                <td>
                                    <x-ui.button type="button" class="btn-sm" wire:click="clearCache('logs')">
                                        <x-spinner wire:loading wire:target="clearCache('logs')" />
                                        Clear log
                                    </x-ui.button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-weight-bold"> Symlink: </span>
                                    To make your files (logo and favicon etc..) accessible from the web, you
                                    should create a symbolic
                                    link.
                                </td>
                                <td>
                                    <x-ui.button type="button" class="btn-sm btn-danger"
                                        wire:click="clearCache('symlink')">
                                        <x-spinner wire:loading wire:target="clearCache('symlink')" />
                                        Create Link
                                    </x-ui.button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
