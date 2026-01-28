<x-slot:title>
    Social Login
</x-slot:title>
<div>
    <x-breadcrumbs title="Social Login">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Social Login</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <fieldset>
                            <legend style="font-size: 14px">
                                <span class="p-2 bg-light"><i class="bi bi-google text-danger"></i></span>
                                <span class="font-weight-bold">via Google</span>
                            </legend>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Client ID</label>
                                    <x-form.input name="google_id" wire:model="google_id" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Client Secret</label>
                                    <x-form.input name="google_secret" wire:model="google_secret" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Redirect URL</label>
                                    <x-form.input name="google_redirect" wire:model="google_redirect" readonly />
                                    <small>
                                        Set this to your Valid OAuth Redirect URI in console.cloud.google.com.
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                        <x-spinner wire:loading wire:target="save" />
                                        Save
                                    </x-ui.button>
                                </div>
                                <div class="form-group col-12">
                                    <small>
                                        Learn <a href="https://app.getonlinetrader.pro/doc/Set-up-Google-authentication"
                                            target="_blank">how to setup your
                                            google login <i class="bi bi-arrow-up-right"></i></a>.
                                    </small>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
