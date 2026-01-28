<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="" wire:submit='saveUser'>
                <div class="mt-3 row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Username" />
                            <x-form.input name="username" wire:model='username' required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Name" />
                            <x-form.input name="name" wire:model='name' required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Email Address" />
                            <x-form.input type='email' name="email" wire:model='email' required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Phone" />
                            <x-form.input type="tel" name="phone_number" wire:model='phone_number' />
                        </div>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Birth Date" />
                            <x-form.input type="date" name="date_of_birth" wire:model='date_of_birth'
                                placeholder="Birth Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <x-form.label label="Country" />
                            <select class="form-control" wire:model='country'>
                                @foreach ($countries as $country)
                                    <option>{{ $country }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('country')
                                    <small class="text-xs text-danger fs-6">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <x-form.label label="Referral Link" />
                            <x-form.input name="refferal_link" wire:model='refferal_link' required />
                        </div>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <x-form.label label="Address" />
                            <x-form.input name="address" wire:model='address' />
                        </div>
                    </div>
                </div>
                <div class="mt-3 mb-3 text-right">
                    <x-ui.button>
                        <i class="bi bi-floppy" wire:loading.remove wire:target="saveUser"></i>
                        <x-spinner wire:loading wire:target="save" />
                        Save
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</div>
