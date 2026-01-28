<x-slot:title>
    Communication
</x-slot:title>
<div>
    <x-breadcrumbs title="Communication">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Communication</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='save'>
                        <div class="form-row">
                            <div class="form-group col-12" wire:ignore>
                                <label>Announcement</label>
                                <textarea name="annoucement" cols="4" class="form-control" wire:model='annoucement'>{!! $annoucement !!}</textarea>
                                {{-- <x-form.editor key="annoucement_" :model="$annoucement" /> --}}
                            </div>
                            <div class="form-group col-12">
                                <label>Welcome messages for new registered users</label>
                                <x-form.input name="welcome_message" wire:model="welcome_message" />
                                <small>This message will be displayed to users whose registration date is less than or
                                    equal to 3 days</small>
                            </div>
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
@script
    <script>
        const editor = CKEDITOR.replace('annoucement', {
            versionCheck: false,
        });
        editor.on('change', function(event) {
            $wire.annoucement = event.editor.getData();
        })
    </script>
@endscript
