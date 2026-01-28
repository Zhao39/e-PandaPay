@use('\Illuminate\Support\Str', 'Str')

<x-slot:title>
    FAQ
</x-slot:title>
<div>
    <x-breadcrumbs title="FAQs">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">FAQs</a>
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
                        @if ($faqs->count() == 0)
                            <div class="text-center">
                                <x-no-data />
                                <h4 class="font-weight-bold">No Data Found</h4>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Question</th>
                                            <th scope="col">Answer</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faqs as $faq)
                                            <tr>
                                                <td>{{ $faq->question }}</td>
                                                <td>
                                                    {{ Str::limit($faq->answer, 80, '...') }}
                                                </td>
                                                <td>
                                                    <a href=""
                                                        wire:click.prevent="setUpdate('{{ $faq->id }}')"
                                                        class="m-1 btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil" wire:loading.remove
                                                            wire:target="setUpdate('{{ $faq->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="setUpdate('{{ $faq->id }}')" />
                                                    </a>
                                                    <button class="m-1 btn btn-danger btn-sm"
                                                        wire:click="delete('{{ $faq->id }}')"
                                                        wire:confirm='Are you sure you want to delete this faq?'>
                                                        <i class="bi bi-trash" wire:loading.remove
                                                            wire:target="delete('{{ $faq->id }}')"></i>
                                                        <x-spinner wire:loading
                                                            wire:target="delete('{{ $faq->id }}')" />
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit='save'>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Question</label>
                                    <x-form.input name="question" wire:model="question" />
                                </div>
                                <div class="form-group col-12">
                                    <label>Answer</label>
                                    <textarea name="answer" wire:model="answer" class="form-control" rows="4"></textarea>
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
                                <div class="form-group col-12">
                                    <label>Question</label>
                                    <x-form.input name="question" wire:model="question" />
                                </div>
                                <div class="form-group col-12">
                                    <label>Answer</label>
                                    <textarea name="answer" wire:model="answer" class="form-control" rows="4"></textarea>
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
