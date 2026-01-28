@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    Web Pages
</x-slot:title>
<div>
    <x-breadcrumbs title="Web Pages">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Web Pages</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        @if (!$edit)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Permalink</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $page)
                                        @if ($page->name !== 'Footer')
                                            <tr>
                                                <td>{{ $page->link_name }}</td>
                                                <td>
                                                    {{ Str::limit($page->title, 80, '...') }}
                                                </td>
                                                <td>{{ $page->permalink }}</td>
                                                <td>
                                                    <span
                                                        @class([
                                                            'badge',
                                                            'badge-success' => $page->status === 'active',
                                                            'badge-danger' => $page->status === 'draft',
                                                        ])>{{ Str::ucfirst($page->status) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.settings.website.contents', ['page' => $page]) }}"
                                                        class="m-1 btn btn-primary btn-sm"
                                                        @if ($settings->spa_mode) wire:navigate @endif>
                                                        <i class="bi bi-body-text"></i>
                                                    </a>

                                                    @if ($page->name != 'Auth')
                                                        <a href=""
                                                            wire:click.prevent="editPage('{{ $page->id }}')"
                                                            class="m-1 btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil" wire:loading.remove
                                                                wire:target="editPage('{{ $page->id }}')"></i>
                                                            <x-spinner wire:loading
                                                                wire:target="editPage('{{ $page->id }}')" />
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($edit)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='saveEdit'>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Link name</label>
                                    <x-form.input name="link_name" wire:model="link_name" />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Page title</label>
                                    <x-form.input name="title" wire:model="title" :readOnly="$name == 'Home'" />
                                    @if ($name == 'Home')
                                        <small>
                                            Homapage Title managed from
                                            <a href="{{ route('admin.settings.general') }}" class="text-primary"
                                                @if ($settings->spa_mode) wire:navigate @endif>general
                                                settings</a>.
                                        </small>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Permalink</label>
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">{{ $url }}</span>
                                        </div>
                                        <input class="form-control" name="permalink" wire:model="permalink"
                                            @readonly($name == 'Home') />
                                    </div>
                                    @isset($errors)
                                        <div>
                                            @error('permalink')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endisset

                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Page Description</label>
                                    <x-form.input name="description" wire:model="description" />
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Page Keywords</label>
                                    <x-form.input name="keywords" wire:model="keywords" />
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Page Status</label>
                                    <x-form.select name="status" wire:model="status" :options="[
                                        'draft' => 'Draft',
                                        'active' => 'Active',
                                    ]" />
                                    <small>Page set to draft will not be accessible.</small>
                                </div>

                                <div class="form-group col-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="saveEdit"></i>
                                        <x-spinner wire:loading wire:target="saveEdit" />
                                        Save
                                    </x-ui.button>
                                    <x-ui.button type="button" class="btn-secondary" wire:click='cancel'>
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
    </div>
</div>
{{-- 
--}}
