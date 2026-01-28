<x-slot:title>
    General Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="General Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">General Settings</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.updateGeneralSettings') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Website Name</label>
                                <x-form.input name="site_name" wire:model="site_name" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Website Title</label>
                                <x-form.input name="site_title" wire:model="site_title" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Website Url</label>
                                <x-form.input name="site_address" placeholder="https://yoursite.com"
                                    wire:model="site_address" required />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Purchase/License Code</label>
                                <x-form.input name="purchase_code" wire:model="purchase_code" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Personal Access Token</label>
                                <x-form.input name="merchant_key" wire:model="merchant_key" />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Live Chat</label>
                                <x-form.input name="live_chat" wire:model="live_chat" />
                                <small>
                                    Enter only the "src" value of the live chat code. If your chat widget does not
                                    support this format (eg tawk.to), you will need to enter the code inside the html
                                    file
                                    directly.
                                </small>
                            </div>
                            <div class="form-group col-lg-6">
                                <div wire:ignore>
                                    <label>Timezone</label>
                                    <select class="select2 form-control" name="timezone">
                                        @foreach ($timezones as $list)
                                            <option value="{{ $list }}">{{ $list }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="font-weight-bold text-muted">Current Timezone:
                                    {{ $timezone }}</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Installation Type</label>
                                <select wire:model="install_type" name="install_type" class="form-control">
                                    <option>Main-Domain</option>
                                    <option>Sub-Domain</option>
                                    <option>Sub-Folder</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Site Logo</label>
                                <div class="mb-3 input-group">
                                    <div>
                                        <x-form.input type="file" name="logo" class="border-0" />
                                    </div>
                                </div>
                                @isset($logo)
                                    <div class="p-2 text-center border rounded-lg">
                                        <img src="{{ asset('storage/' . $logo) }}" width="60">
                                    </div>
                                @endisset
                                <small>
                                    You can manage logo sizes from <a href="{{ route('admin.settings.center') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>here</a>
                                </small>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Favicon</label>
                                <div class="mb-3 input-group">
                                    <div>
                                        <x-form.input type="file" name="favicon" class="border-0" />
                                    </div>
                                </div>
                                @isset($favicon)
                                    <div class="p-2 text-center border">
                                        <img src="{{ asset('storage/' . $favicon) }}" width="60">
                                    </div>
                                @endisset
                            </div>
                            <div class="form-group col-md-6">
                                <label>Admin Base URL</label>
                                <x-form.input name="admin_base_url" wire:model="admin_base_url" />
                                <small>
                                    This setting allows you to customize the base URL for the admin dashboard. For
                                    example, if you enter /admin, the admin dashboard will be accessible at
                                    https://mysiteurl.com/admin/other-url. If you change it to /manager, the
                                    dashboard
                                    will move
                                    to https://mysiteurl.com/manager/other-url. Choose a URL path that is easy for
                                    you
                                    to remember but secure.
                                </small>
                            </div>
                            <div class="form-group col-md-12">
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

@script
    <script>
        const selects = $('.select2');
        selects.select2();
    </script>
@endscript
