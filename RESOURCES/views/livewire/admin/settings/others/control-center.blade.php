<x-slot:title>
    Control Center
</x-slot:title>
<div>
    <x-breadcrumbs title="Control Center">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Control Center</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label>Admin Dashboard Logo Size</label>
                                <x-form.input type="number" name="admin_dashboard_logo_size"
                                    wire:model="admin_dashboard_logo_size" />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>User Dashboard Logo Size</label>
                                <x-form.input type="number" name="user_dashboard_logo_size"
                                    wire:model="user_dashboard_logo_size" />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Website Logo Size</label>
                                <x-form.input name="website_logo_size" wire:model="website_logo_size" />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Auth Pages Logo Size</label>
                                <x-form.input name="auth_pages_logo_size" wire:model="auth_pages_logo_size" />
                            </div>
                            @can('view activty log')
                                <div class="form-group col-lg-6">
                                    <label>Clean Recorded activity log after how many days</label>
                                    <x-form.input type="number" name="delete_records_older_than_days"
                                        wire:model="delete_records_older_than_days" />
                                    <small>This will result in the deletion of all recorded activity that is older than the
                                        number of days specified. <a href="{{ route('admin.platform.activitiesLog') }}"
                                            @if ($settings->spa_mode) wire:navigate @endif>View Logs</a></small>
                                </div>
                            @endcan
                            <div class="form-group col-12">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                    <x-spinner wire:loading wire:target="save" />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
