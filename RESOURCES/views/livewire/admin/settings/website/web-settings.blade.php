@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Website Settings
</x-slot:title>
<div>
    <x-breadcrumbs title=" Website Settings">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"> Website Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>HomePage Redirect Url</label>
                                <x-form.input name="redirect_url" wire:model="redirect_url"
                                    placeholder="eg https://myhomepage.com" />
                                <small>
                                    If you use a custom homepage and you want all request to be rediected to that page,
                                    please
                                    enter the url here, if empty the system will use our default homepage/webpages
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Homepage Theme</label>
                                <x-form.select name="home_theme" wire:model="home_theme" :options="[
                                    'home1' => 'Homepage 1',
                                    'home2' => 'Homepage 2',
                                ]" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Show Plans on Homepage</label>
                                <x-preference label="">
                                    <x-slot:check1>
                                        <x-radio wire:model='show_plans_on_home_page' value="1" label="Yes" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='show_plans_on_home_page' value="0" label="No" />
                                    </x-slot:check2>
                                </x-preference>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Facebook Social Media Link</label>
                                <x-form.input name="facebook_social_link" wire:model="facebook_social_link" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>X/Twitter Social Media Link</label>
                                <x-form.input name="x_social_link" wire:model="x_social_link" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Instagram Social Media Link</label>
                                <x-form.input name="instagram_social_link" wire:model="instagram_social_link" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Maintenance Mode</label>
                                <x-preference label="">
                                    <x-slot:check1>
                                        <x-radio wire:model='site_in_maintenance_mode' value="1" label="Enable" />
                                    </x-slot:check1>
                                    <x-slot:check2>
                                        <x-radio wire:model='site_in_maintenance_mode' value="0" label="Disable" />
                                    </x-slot:check2>
                                </x-preference>
                                <small class="d-block">
                                    If you enable maintenance mode, your site will not be accessible temporarily and you
                                    will need a bypass token to have access, untill you disable it. <strong>Note: Set
                                        your
                                        bypass
                                        token below before you enable maintenance mode.</strong>
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Maintenance Mode Bypass Token</label>
                                <x-form.input name="maintenance_mode_token" wire:model.live="maintenance_mode_token" />
                                <small class="d-block">
                                    Your Bypass token to access your website when maintenance mode is enabled.
                                    <strong>Your maintenance mode secret should typically consist of alpha-numeric
                                        characters and, optionally, dashes. You should avoid using characters that have
                                        special meaning in URLs such as ? or &.</strong>
                                </small>
                                @if ($maintenance_mode_token)
                                    <small class="mt-3">
                                        Use <strong>{{ $url }}/{{ $maintenance_mode_token }} </strong> to
                                        access your site while in maintenance mode.
                                    </small>
                                @endif
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
                    <hr>
                    <h4 class="mb-0 font-weight-bold">Password Validation Rules</h4>
                    <small class="mt-0">Set password validation rules for your website</small>
                    <div class="mt-2">
                        <form wire:submit='saveRules'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Minimum Characters</label>
                                    <x-form.input name="leastChar" wire:model="leastChar" required="true" type="number"
                                        min="8" />
                                    <small>
                                        Minimum number of characters for password
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Use Mixed case">
                                        <x-slot:check1>
                                            <x-radio wire:model='mixedCase' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='mixedCase' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Password require at least one uppercase and one lowercase letter
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Use Letters">
                                        <x-slot:check1>
                                            <x-radio wire:model='letters' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='letters' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Password require at least one letter
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Use Numbers">
                                        <x-slot:check1>
                                            <x-radio wire:model='numbers' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='numbers' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Password require at least one number
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Use Symbols">
                                        <x-slot:check1>
                                            <x-radio wire:model='symbols' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='symbols' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Password require at least one symbol
                                    </small>
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-preference label="Use Uncompromised">
                                        <x-slot:check1>
                                            <x-radio wire:model='uncompromised' value="1" label="Yes" />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio wire:model='uncompromised' value="0" label="No" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small class="d-block">
                                        Require that the password has not been compromised in a public password
                                        data breach leak
                                    </small>
                                </div>
                                <div class="form-group col-md-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="saveRules"></i>
                                        <x-spinner wire:loading wire:target="saveRules" />
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
</div>
