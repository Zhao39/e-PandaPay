@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    Page content
</x-slot:title>
<div>
    <x-breadcrumbs title="{{ $page->name == 'Footer' ? 'Footer' : $page->link_name . ' Page' }} content">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.website.pages') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Pages
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"> Page content</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        @if ($page->name != 'Terms')
            @foreach ($contents as $content)
                <div class="col-lg-6">
                    <form action="{{ route('admin.settings.website.saveContent') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                @if ($content->title)
                                    <div class="mb-1">
                                        <x-form.input name="title" value="{{ $content->title }}" />
                                    </div>
                                @endif
                                @if ($content->description)
                                    <div class="mb-1">
                                        <textarea name="description" class="form-control" rows="4" name="description">
                                            {{ $content->description }}
                                        </textarea>
                                    </div>
                                @endif
                                <input type="hidden" name="ref_key" value="{{ $content->ref_key }}">
                                @if ($content->ref_key != '39043d' || $settings->theme == 'dashly')
                                    @if ($content->img_path)
                                        <div class="mb-1" x-data="{ change: false }">
                                            <img src="{{ asset('storage/' . $content->img_path) }}" alt=""
                                                width="100" x-show="!change">
                                            <a href="" @click.prevent="change = !change">
                                                <i x-bind:class="!change ? 'bi bi-pencil' : 'bi bi-x text-danger'"></i>
                                            </a>
                                            <div x-show="change" class="row" style="display: none">
                                                @foreach ($this->images as $image)
                                                    <div class="col-3">
                                                        <label class="mb-2 imagecheck">
                                                            <input type="radio" value="{{ $image->path }}"
                                                                class="imagecheck-input" name="img_path">
                                                            <figure class="imagecheck-figure">
                                                                <img src="{{ asset('storage/' . $image->path) }}"alt="{{ $image->title }}"
                                                                    class="imagecheck-image w-50">
                                                            </figure>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="mb-1">
                                        <input type="color" name='img_path' value="{{ $content->img_path }}"
                                            class="w-100">
                                    </div>
                                @endif
                                <div class="mb-1">
                                    <x-ui.button>
                                        Save
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='saveTerms'>
                            <div wire:ignore>
                                <textarea name="message" cols="4" class="form-control" wire:model='message' required>
                                    {{ $page->description }}
                                </textarea>
                                <div>
                                    @error('message')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <x-ui.button>
                                    <x-spinner wire:loading wire:target="saveTerms" />
                                    Save
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@script
    <script>
        const editor = CKEDITOR.replace('message', {
            versionCheck: false,
        });
        const editor = CKEDITOR.replace('message', {
            versionCheck: false,
        });
        editor.on('change', function(event) {
            $wire.message = event.editor.getData();
        });
    </script>
@endscript
