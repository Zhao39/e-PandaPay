<x-slot:title>
    Courses Categories
</x-slot:title>
<div x-data="{ name: '', addNew: @entangle('addNew') }">
    <x-breadcrumbs title=" Courses Categories">
        <li class="nav-item">
            <a href="#"> Courses Categories</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    @session('error')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <strong> {{ $value }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endsession
    <div class="row">
        @if ($categories)
            <div class="mb-4 text-right col-12" x-show="!addNew">
                <a href="" class="btn btn-primary" @click.prevent="addNew = true">
                    <i class="fa fa-plus" wire:loading.remove wire:target="addNew"></i>
                    <x-spinner wire:loading wire:target="addNew" />
                    Add New
                </a>
            </div>
        @endif
        <div class="col-lg-8 offset-lg-2" x-show="addNew" style="display: none">
            <div class="card">
                <div class="card-body">
                    <form action="" wire:submit='save'>
                        <div class="mb-3">
                            <x-form.label>Category Name</x-form.label>
                            <x-form.input name='categoryName' x-model='name' wire:model='categoryName'
                                placeholder='Enter Value here' required autofocus />
                        </div>
                        <div class="mb-3 text-right">
                            <x-ui.button>
                                <i class="bi bi-floppy" wire:loading.remove wire:target="save"></i>
                                <x-spinner wire:loading wire:target="save" />
                                Save
                            </x-ui.button>
                            <x-ui.button type='button' class="btn-danger" @click="addNew = false; name = ''">
                                Cancel
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12" x-show="!addNew">
            <div class="row">
                @if ($categories)
                    @foreach ($categories as $item)
                        @php
                            $id = $item['category']['id'];
                        @endphp
                        <div class="col-lg-4 col-6">
                            <div class="border card">
                                <div class="card-body">
                                    <h4 class="font-weight-bold">{{ $item['category']['category'] }}</h4>
                                    <button wire:click="delete('{{ $id }}')"
                                        wire:confirm="Are you sure you want to delete this category?"
                                        class="mt-2 text-right btn btn-danger btn-sm" wire:loading.attr='disabled'>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="text-center card-body">
                                <x-no-data />
                                <h5 class=" font-weight-bold">No Data Available</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
