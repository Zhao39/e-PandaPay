@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    Testimony
</x-slot:title>
<div>
    <x-breadcrumbs title="Testimony">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Testimony</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        @if (!$add && !$edit)
            <div class="col-12">
                <div class="mb-2 text-right col-12">
                    <a href="#" class="btn btn-primary" wire:click="$set('add', true)">
                        <i class="fas fa-plus-circle" wire:loading.remove wire:target="add"></i>
                        <x-spinner wire:loading wire:target="add" />
                        Add New
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($tests->count() == 0)
                            <div class="text-center">
                                <x-no-data />
                                <h4 class="font-weight-bold">No Data Found</h4>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Date</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tests as $test)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <img src="{{ asset('storage/' . $test->picture) }}"
                                                                style="width: 40px" class="rounded-circle img-fluid">
                                                        </div>
                                                        &nbsp;
                                                        <div>
                                                            {{ $test->name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $test->position }}</td>
                                                <td>
                                                    {{ Str::limit($test->what_is_said, 80, '...') }}
                                                </td>
                                                <td>{{ $test->created_at->toDayDateTimeString() }}</td>
                                                <td>
                                                    <a href=""
                                                        wire:click.prevent="setUpdate('{{ $test->id }}')"
                                                        class="m-1 btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil" wire:loading.remove
                                                            wire:target="setUpdate('{{ $test->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="setUpdate('{{ $test->id }}')" />
                                                    </a>
                                                    <button class="m-1 btn btn-danger btn-sm"
                                                        wire:click="delete('{{ $test->id }}')"
                                                        wire:confirm='Are you sure you want to delete this testimony?'>
                                                        <i class="bi bi-trash" wire:loading.remove
                                                            wire:target="delete('{{ $test->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $test->id }}')" />
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if ($add)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='save'>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Name</label>
                                    <x-form.input name="name" wire:model="name" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Position or Ttile</label>
                                    <x-form.input name="position" wire:model="position" required />
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Testimony</label>
                                    <x-form.input name="what_is_said" wire:model="what_is_said" required />
                                    <div>
                                        @error('what_is_said')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="form-label">Select User Picture</label>
                                    <div class="row">
                                        @foreach ($this->medias as $image)
                                            <div class="col-6 col-sm-2">
                                                <label class="mb-2 imagecheck">
                                                    <input wire:model='picture' type="radio"
                                                        value="{{ $image->path }}" class="imagecheck-input" required>
                                                    <figure class="imagecheck-figure">
                                                        <img src="{{ asset('storage/' . $image->path) }}"alt="{{ $image->title }}"
                                                            class="imagecheck-image w-50">
                                                    </figure>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        @error('picture')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <x-ui.button>
                                        <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                        <x-spinner wire:loading wire:target="save" />
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
        @if ($edit)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='saveEdit'>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Name</label>
                                    <x-form.input name="name" wire:model="name" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Position or Ttile</label>
                                    <x-form.input name="position" wire:model="position" required />
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Testimony</label>
                                    <x-form.input name="what_is_said" wire:model="what_is_said" required />
                                    <div>
                                        @error('what_is_said')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="form-label">Select User Picture</label>
                                    <div class="row">
                                        @foreach ($this->medias as $image)
                                            <div class="col-6 col-sm-2">
                                                <label class="mb-2 imagecheck">
                                                    <input wire:model='picture' type="radio"
                                                        value="{{ $image->path }}" class="imagecheck-input"
                                                        required>
                                                    <figure class="imagecheck-figure">
                                                        <img src="{{ asset('storage/' . $image->path) }}"alt="{{ $image->title }}"
                                                            class="imagecheck-image w-50">
                                                    </figure>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        @error('picture')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
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
