<x-slot:title>
    System CleanUp
</x-slot:title>
<div>
    <x-breadcrumbs title="System CleanUp">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Platform Administration
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">System CleanUp </a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="alert alert-danger" role="alert">
                Please backup your database before cleanup, This action will clear your data in
                your database. You can ignore tables that you do not want to be cleaned. Note: Our Default records will
                not be cleared.
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Table</th>
                                    <th>Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tables as $table)
                                    @if (
                                        $table['name'] !== 'activity_log' &&
                                            $table['name'] !== 'cache' &&
                                            $table['name'] !== 'cache_locks' &&
                                            $table['name'] !== 'contents' &&
                                            $table['name'] !== 'failed_jobs' &&
                                            $table['name'] !== 'migrations' &&
                                            $table['name'] !== 'model_has_permissions' &&
                                            $table['name'] !== 'model_has_roles' &&
                                            $table['name'] !== 'password_reset_tokens' &&
                                            $table['name'] !== 'permissions' &&
                                            $table['name'] !== 'personal_access_tokens' &&
                                            $table['name'] !== 'role_has_permissions' &&
                                            $table['name'] !== 'roles' &&
                                            $table['name'] !== 'sessions' &&
                                            $table['name'] !== 'email_templates' &&
                                            $table['name'] !== 'pages' &&
                                            $table['name'] !== 'payment_methods' &&
                                            $table['name'] !== 'settings')
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model='checkedrecord'
                                                    value="{{ $table['name'] }}" />
                                                {{-- <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input">
                                                    <span class="form-check-sign"></span>
                                                </label> --}}
                                            </td>
                                            <td>
                                                {{ $table['name'] }}
                                            </td>
                                            <td>
                                                {{ $table['records'] }}
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No Activity Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-right card-footer">
                    <x-ui.button type="button" class="btn-danger" wire:click='cleanUp'
                        wire:confirm="Are you sure you want to perform this action?">
                        <i wire:loading.remove class="bi bi-exclamation-triangle"></i>
                        <x-spinner wire:loading />
                        Cleanup
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
