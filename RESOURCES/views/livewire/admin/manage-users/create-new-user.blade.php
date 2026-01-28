@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Add new user
</x-slot:title>
<div>
    <x-breadcrumbs title="Add new User">
        <li class="nav-item">
            <a href="#">Add User</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-8 offset-lg-2" x-data="{
            inputText: '',
            referral: '',
            handleClick() {
                this.inputText = this.inputText.replace(/\s/g, '');
                this.referral = this.referral.replace(/\s/g, '');
            }
        }">
            <div class="card">
                <div class="card-body">
                    <form action="" wire:submit='saveUser'>
                        <div class="row">
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Username" />
                                <x-form.input @keyup="handleClick()" x-model="inputText" name='username'
                                    wire:model='username' required autofocus />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Fullname" />
                                <x-form.input name='name' wire:model='name' required autofocus />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Email Address" />
                                <x-form.input type="email" name='email' wire:model='email' required autofocus />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Phone Number" />
                                <x-form.input type="tel" name='phone_number' wire:model='phone_number' required
                                    autofocus />
                            </div>
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Countries" />
                                <select class="form-control" wire:model='country' required>
                                    <option selected disabled>Select Country..</option>
                                    @foreach ($countries as $country)
                                        <option>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-lg-6">
                                <x-form.label label="Reffered By (Username)" />
                                <x-form.input @keyup="handleClick()" x-model="referral" name='reffered_by'
                                    wire:model='reffered_by' autofocus />
                            </div>
                            <div class="mb-3 col-lg-12">
                                <x-form.label label="Password" />
                                <x-form.input type="password" name='password' wire:model='password' required
                                    autofocus />
                            </div>
                            <div class="mb-3 col-lg-12">
                                <x-form.label label="Confirm Password" />
                                <x-form.input type="password" name='password_confirmation'
                                    wire:model='password_confirmation' required autofocus />
                            </div>

                            <div class="mb-3 col-lg-12">
                                <x-ui.button wire:click="$set('saveType', 'save')">
                                    <i class="bi bi-floppy" wire:loading.remove wire:target="saveUser"></i>
                                    <x-spinner wire:loading wire:target="saveUser" />
                                    Save
                                </x-ui.button>
                                <x-ui.button class="border btn-light border-dark"
                                    wire:click="$set('saveType', 'save & exit')">
                                    <i class="bi bi-save" wire:loading.remove wire:target="saveUser"></i>
                                    <x-spinner wire:loading wire:target="saveUser" />
                                    Save & Exit
                                </x-ui.button>
                                <x-ui.button type='reset' class="btn-secondary">
                                    <i class="bi bi-x-square"></i>
                                    Reset
                                </x-ui.button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<x-slot:scripts>
    <script>
        $('#modalBtn').on('click', function() {
            $('#exampleModal').modal({
                backdrop: true,
                show: true
            })
        });
    </script>
</x-slot:scripts>
