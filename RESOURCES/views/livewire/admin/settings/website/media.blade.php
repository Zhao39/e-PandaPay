@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    Media
</x-slot:title>
<div>
    <x-breadcrumbs title="Media">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Media</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        @if (!$add && !$edit)
            <div class="mb-3 col-lg-12">
                <div class="mb-2 text-right col-12">
                    <a href="#" class="btn btn-primary" wire:click="$set('add', true)">
                        <i class="fas fa-plus-circle" wire:loading.remove wire:target="add"></i>
                        <x-spinner wire:loading wire:target="add" />
                        Add New
                    </a>
                </div>
            </div>
        @endif
        @if ($add)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.website.addMedia') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Images</label>
                                    <input type="file" class="border-0 form-control" name="photos[]" multiple />
                                    <small>'jpg', 'jpeg', 'png', 'webp', 'pdf', 'mp4', 'webm', 'gif'</small>
                                    <div class="mt-2">
                                        @error('photos.*')
                                            <small class="text-xs text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <small class="text-info">
                                        If you encounter an error asking you to select an image even though you have
                                        already chosen one,
                                        please click the 'Save' button again.
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button class="btn-sm">
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                        <x-spinner wire:loading wire:target="save" />
                                        Save
                                    </x-ui.button>
                                    <x-ui.button type="button" class="btn-secondary btn-sm" wire:click='cancel'>
                                        <x-spinner wire:loading wire:target="cancel" />
                                        Cancel
                                    </x-ui.button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if ($edit)
            <div class="col-12" wire:transition>
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='saveEdit'>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Images</label>
                                    <x-form.input type="file" name="photos" wire:model="photos" multiple />
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button class="btn-sm">
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="saveEdit"></i>
                                        <x-spinner wire:loading wire:target="saveEdit" />
                                        Save
                                    </x-ui.button>
                                    <x-ui.button type="button" class="btn-secondary btn-sm" wire:click='cancel'>
                                        <x-spinner wire:loading wire:target="cancel" />
                                        Cancel
                                    </x-ui.button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @foreach ($images as $image)
            <div class="mb-2 col-lg-2 col-6 position-relative">
                <div class="bottom-0 p-2 position-absolute">
                    {{-- <a href=""><span class="p-1 bg-dark"><i class="bi bi-pencil text-primary"></i></span></a> --}}
                    <a href="" wire:click.prevent="delete('{{ $image->id }}')"
                        wire:confirm='Are you sure you want to delete this image?'><span class="p-1 bg-dark">
                            <i class="bi bi-trash text-danger" wire:loading.remove
                                wire:target="delete('{{ $image->id }}')"></i>
                            <x-spinner wire:loading wire:target="delete('{{ $image->id }}')" />
                        </span></a>
                </div>
                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->title }}"
                    class="img-thumbnail w-lg-100">
            </div>
        @endforeach
    </div>
</div>
