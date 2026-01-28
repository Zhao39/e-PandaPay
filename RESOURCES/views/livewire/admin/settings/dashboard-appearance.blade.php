<x-slot:title>
    Dashboard Appearance
</x-slot:title>
<div>
    <x-breadcrumbs title="Dashboard Appearance">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Dashboard Appearance</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='addTheme'>
                        <div class="form-group">
                            <label>Upload new User dashboard Theme (zip file)</label>
                            <x-form.input type="file" name='theme_file' class="border-0" wire:model='theme_file'
                                required />
                            <small>
                                Please verify that your theme is compatible with this version. Otherwise, you may
                                encounter errors when opening the user dashboard.
                            </small>
                        </div>
                        <div class="text-right form-group">
                            <x-ui.button>
                                <i class="bi bi-floppy" wire:loading.remove wire:target="addTheme"></i>
                                <x-spinner wire:loading wire:target="addTheme" />
                                Save
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='saveTheme' x-data="{ theme: @entangle('theme') }">
                        <div class="form-group">
                            <label>Current user dashboard theme</label>
                            <select class="form-control" wire:model='theme' x-model="theme">
                                @foreach ($themes as $item)
                                    <option>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right form-group">
                            <x-ui.button type="button" style="display: none" class="btn-danger"
                                wire:click='deleteTheme' x-show="theme != 'purpose' && theme != 'millage'"
                                wire:confirm='Are you sure you want to delete this theme?'>
                                <i class="bi bi-x-circle" wire:loading.remove wire:target="deleteTheme"></i>
                                <x-spinner wire:loading wire:target="deleteTheme" />
                                Delete
                            </x-ui.button>
                            <x-ui.button>
                                <i class="bi bi-floppy" wire:loading.remove wire:target="saveTheme"></i>
                                <x-spinner wire:loading wire:target="saveTheme" />
                                Save
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="m-0 font-weight-bold">
                        Website Primary Color.
                    </h4>
                    <p class="m-0">
                        This will affect the admin dashboard and the user dashboard with millage and
                        purpose themes only.
                    </p>
                    <div class="mt-3 row">
                        <div class="col-lg-6">
                            <input type="color" wire:model='website_theme' class="w-100">
                        </div>
                        <div class="mt-3 col-12">
                            <x-ui.button wire:click='updateColour'>
                                <i class="bi bi-floppy" wire:loading.remove wire:target="updateColour"></i>
                                <x-spinner wire:loading wire:target="updateColour" />
                                Save
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
