<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form wire:submit='save'>
                    <div class="form-row">
                        <div class="mb-3 col-12">
                            <label>Title</label>
                            <x-form.input name="title" wire:model='title' required />
                        </div>
                        <div class="mb-3 col-12">
                            <label>Description</label>
                            <textarea name="description" wire:model='description' rows="5" class="form-control"required></textarea>
                        </div>
                        <div class="mb-3 col-12">
                            <label>Assigned To</label>
                            <select name="user_id" wire:model='user_id' class="form-control">
                                <option selected>Select Admin....</option>
                                @foreach ($this->admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('user_id')
                                    <small class="text-xs text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>Start Date</label>
                            <x-form.input name="start_date" type="date" wire:model='start_date' required />
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label>End Date</label>
                            <x-form.input name="end_date" type="date" wire:model='end_date' required />
                        </div>
                        <div class="mb-3 col-12">
                            <label>Priority</label>
                            <x-form.select name="priority" wire:model='priority' :options="[
                                'Immediately' => 'Immediately',
                                'High' => 'High',
                                'Medium' => 'Medium',
                                'Low' => 'Low',
                            ]" required />
                        </div>
                        <div class="col-12">
                            <x-ui.button>
                                Submit
                            </x-ui.button>
                            <x-ui.button type="button" class="btn-secondary" wire:click='resetProps'>
                                <x-spinner wire:loading wire:target="resetProps" />
                                Cancel
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
