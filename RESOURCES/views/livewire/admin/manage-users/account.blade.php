<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-6">
                    <x-preference label="Account Status">
                        <x-slot:check1>
                            <x-radio name='name' wire:model.live='status' value="active" label="Active" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='name' wire:model.live='status' value="blocked" label="Blocked" />
                        </x-slot:check2>
                    </x-preference>
                    <x-spinner wire:loading wire:target='status' />
                </div>
                <div class="mb-3 col-6">
                    <x-preference label="Automatic Trade">
                        <x-slot:check1>
                            <x-radio name='autoTrade' wire:model.live='trade_mode' value="1" label="On" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='autoTrade' wire:model.live='trade_mode' value="0" label="Off" />
                        </x-slot:check2>
                    </x-preference>
                    <x-spinner wire:loading wire:target='trade_mode' />
                    <small class="mt-1 d-block" style="font-size: 10px">
                        Specifies if {{ $user->name }} should receive automatic <br> ROI when they buy an investment
                        plan.
                    </small>
                </div>
                <div class="mb-3 col-6">
                    <x-preference label="Can Deposit">
                        <x-slot:check1>
                            <x-radio name='can_deposit' wire:model.live='can_deposit' value="1" label="Yes" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='can_deposit' wire:model.live='can_deposit' value="0" label="No" />
                        </x-slot:check2>
                    </x-preference>
                    <x-spinner wire:loading wire:target='can_deposit' />
                    <small class="mt-1 d-block" style="font-size: 10px">
                        Specifies if {{ $user->name }} can make deposit.
                    </small>
                </div>
                <div class="mb-3 col-6">
                    <x-preference label="Can Withdraw">
                        <x-slot:check1>
                            <x-radio name='can_withdraw' wire:model.live='can_withdraw' value="1" label="Yes" />
                        </x-slot:check1>
                        <x-slot:check2>
                            <x-radio name='can_withdraw' wire:model.live='can_withdraw' value="0" label="No" />
                        </x-slot:check2>
                    </x-preference>
                    <x-spinner wire:loading wire:target='can_withdraw' />
                    <small class="mt-1 d-block" style="font-size: 10px">
                        Specifies if {{ $user->name }} can place a withdrawal.
                    </small>
                </div>
            </div>
            @if (!$user->email_verified_at)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <x-ui.button wire:click='markAsVerified' type="button">
                            Mark Email as Verified
                        </x-ui.button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <livewire:admin.manage-users.adjust-account :user="$user" />
        </div>
    </div>
</div>
<div class="col-lg-12" x-data="{ action: '' }">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-12">
                    <x-ui.button type="button" class="m-1" @click="action = 'getaccess'">
                        <i class="bi bi-floppy"></i>
                        Get Access
                    </x-ui.button>
                    <x-ui.button class="m-1 btn-warning" type="button" @click="action = 'clearaccount'">
                        <i class="bi bi-arrow-repeat"></i>
                        Clear Account
                    </x-ui.button>
                    @can('delete user')
                        <x-ui.button class="m-1 btn-danger" type="button" @click="action = 'deleteaccount'">
                            <i class="bi bi-trash"></i>
                            Delete Account
                        </x-ui.button>
                    @endcan
                </div>
            </div>
            <div class="row" x-show="action != ''">
                <div class="mb-2 text-right col-12">
                    <a href="" @click.prevent="action = ''">
                        <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                    </a>
                </div>
                <div class="col-12" x-show="action == 'getaccess'">
                    <h5 class="m-0 text-muted font-weight-bold">You are about to login as <span
                            class="text-primary">{{ $user->name }}</span> </h5>
                    <x-ui.button class="m-1 btn-success" type="button" wire:click='loginAsUser'>
                        Yes, Proceed
                    </x-ui.button>
                </div>
                <div class="col-12" x-show="action == 'clearaccount'">
                    <h5 class="text-muted font-weight-bold">You are about to clear <span
                            class="text-primary">{{ $user->name }}</span> account. This Action is not reversible</h5>
                    <form action="" wire:submit='clearAccount'>
                        <div class="mb-3">
                            <x-form.label label="Choose what to clear" />
                            <x-form.select label="whatToClear" wire:model.live='whatToClear' :options="[
                                'account_bal' => 'Account Balance',
                                'roi' => 'Profit Column',
                                'bonus' => 'Bonus Column',
                                'ref_bonus' => 'Referral Bonus Column',
                                'deposits' => 'Deposit Record',
                                'withdrawal' => 'Withdrawal Record',
                                'transaction' => 'Transaction History',
                                'plans' => 'Investment Plans',
                            ]"
                                multiple required />
                        </div>
                        <div class="mb-3">
                            <x-ui.button>
                                <x-spinner wire:loading wire:target="clearAccount" />
                                Submit
                            </x-ui.button>
                        </div>
                    </form>
                </div>
                <div class="col-12" x-show="action == 'deleteaccount'">
                    <h5 class="m-0 text-muted font-weight-bold">You are about to delete <span
                            class="text-primary">{{ $user->name }}</span> account. This Action is not reversible</h5>
                    <x-ui.button class="m-1 btn-danger" type="button" wire:click='deleteAccount'
                        wire:confirm='Are you sure you want to delete this account'>
                        <x-spinner wire:loading wire:target="deleteAccount" />
                        Yes, Delete
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
