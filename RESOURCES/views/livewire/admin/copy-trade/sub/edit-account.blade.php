<div>
    <form action="" wire:submit='save'>
        <div class="mb-2">
            <select class="form-control" wire:model='user_id'>
                @foreach ($this->users as $user)
                    <option wire:key='{{ $user->id }}' value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <x-form.input name="name" wire:model='name' placeholder="Account Name" required />
        </div>
        <div class="mb-2">
            <x-form.input name="login" wire:model='login' placeholder="Account Login/Account ID" required />
        </div>
        <div class="mb-2">
            <x-form.input name="password" wire:model='password' placeholder="Account Password" required />
        </div>
        <div class="mb-2">
            <x-form.select name="platform" wire:model='platform' :options="[
                'mt4' => 'MT4',
                'mt5' => 'MT5',
            ]" />
        </div>
        <div class="mb-2">
            <x-form.input name="account_type" wire:model='account_type' placeholder="Account Type eg Standard"
                required />
        </div>
        <div class="mb-2">
            <x-form.input name="currency" wire:model='currency' placeholder="Currency eg USD" required />
        </div>
        <div class="mb-2">
            <x-form.input name="leverage" wire:model='leverage' placeholder="Leverage" required />
        </div>
        <div class="mb-2">
            <x-form.input name="server" wire:model='server' placeholder="Server" required />
        </div>
        <div class="mb-2">
            <x-ui.button class="btn-sm">
                <x-spinner wire:loading wire:target="save" />
                Update
            </x-ui.button>
            <x-ui.button type='button' class="btn-sm btn-secondary" wire:click="$parent.resetProps()">
                Cancel
            </x-ui.button>
        </div>
    </form>
</div>
