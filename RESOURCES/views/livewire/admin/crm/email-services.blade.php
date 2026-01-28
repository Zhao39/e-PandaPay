@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Send Email
</x-slot:title>

<div x-data="{
    category: @entangle('category'),
    init() {
        $watch('category', function(value) {})
    }
}">
    <x-breadcrumbs title="Email Service">
        <li class="nav-item">
            <a href="#">Email</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-md-12">
            <div class="p-2 shadow card ">
                <div class="card-body">
                    <form wire:submit='send'>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" x-model='category' wire:model='category'>
                                <option value="All">All Users</option>
                                <option value="No Active Plans">Users without investment plan</option>
                                <option value="No Deposit">
                                    Users without any Deposit (likely to be new users)
                                </option>
                                <option value="No Withdrawal">
                                    Users without any Withdrawal
                                </option>
                                <option value="Select Users">Choose Users</option>
                            </select>
                        </div>

                        <div class="form-group" style="display: none" x-show="category == 'Select Users'">
                            <label>Select Users</label>
                            <select class="form-control" id="select2" multiple style="width: 100%">
                                @foreach ($this->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Greeting/Title</label>
                            <div class="input-group">
                                <x-form.input wire:model='greeting' name="greeting" />
                                <x-form.input wire:model='title' name="title" />
                            </div>
                            <small class="text-right">The {$fullname} will make use of the user's fullname in the
                                database.</small>
                        </div>

                        <div class="form-group">
                            <label>Subject</label>
                            <x-form.input wire:model='subject' name="subject" placeholder="Subject" required />
                        </div>
                        <div class="form-group col-md-12" wire:ignore>
                            <label>Description</label>
                            <textarea name="message" cols="4" class="form-control" wire:model='message' required></textarea>
                            <div>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <x-ui.button>
                                <x-spinner wire:loading wire:target="send" />
                                Send
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        const editor = CKEDITOR.replace('message', {
            versionCheck: false,
        });
        editor.on('change', function(event) {
            $wire.message = event.editor.getData();
        });

        const select = $('#select2');
        select.select2({
            placeholder: "Select Users",
            allowClear: true
        });
        select.on('change', function() {
            const options = $('#select2').select2('data');
            const selectedOptions = [];
            options.forEach(element => {
                selectedOptions.push(element.id);
            });
            $wire.users_id = selectedOptions;
        });
    </script>
@endscript
