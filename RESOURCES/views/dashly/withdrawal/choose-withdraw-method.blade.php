@use('\Illuminate\Support\Number', 'Number')
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            Withdraw from your account.
        </h1>
        <p class="m-0">Place a withdrawal request using any of the payment method below.</p>
    </div>
    <x-danger-alert />
    <x-success-alert />
    @if (!$request)
        <div class="row">
            @foreach ($methods as $method)
                <div class="mb-3 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="py-0 border-0 card-header">
                                    <span
                                        class="px-4 py-1 mx-auto shadow-sm h6 d-inline-block rounded-bottom font-weight-bold">
                                        {{ $method->name }}
                                    </span>

                                    <div class="py-5">
                                        <img src="{{ $method->img_url ? $method->img_url : asset('themes/purpose/img/Wallet.svg.png') }}"
                                            alt="withdrawal method image" srcset="" class="img-fluid img-center"
                                            style="height:60px;">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-4 list-unstyled">
                                        <li class="d-flex justify-content-between">
                                            <p>Minimum Amount:</p>
                                            <p class="font-weight-bold fw-bold">
                                                {{ Number::currency($method->minimum, $settings->s_currency) }}
                                            </p>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <p>Maximum Amount</p>
                                            <p class="font-weight-bold fw-bold">
                                                {{ Number::currency($method->maximum, $settings->s_currency) }}
                                            </p>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <p>
                                                Charges Amount:
                                            </p>
                                            <strong>
                                                @if ($method->charges_type == 'percentage')
                                                    {{ Number::percentage($method->charges_amount) }}
                                                @else
                                                    {{ Number::currency($method->charges_amount, $settings->s_currency) }}
                                                @endif
                                            </strong>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <p>
                                                Note:
                                            </p>
                                            <strong>{{ $method->duration }}</strong>
                                        </li>
                                    </ul>
                                    <x-ui.button type='button' class="btn-sm"
                                        wire:click="requestWithdrawal({{ $method->id }})">
                                        <x-spinner wire:loading wire:target="requestWithdrawal({{ $method->id }})" />
                                        <i class="bi bi-plus" wire:loading.remove
                                            wire:target="requestWithdrawal({{ $method->id }})"></i>
                                        Request withdrawal
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if ($request)
        <div class="row">
            <div class="mb-3 text-end col-12">
                <x-ui.button type='button' class="btn-sm btn-info" wire:click="$set('request', false)">
                    <x-spinner wire:loading wire:target="request" />
                    <i class="bi bi-x" wire:loading.remove wire:target="request"></i>
                    Cancel
                </x-ui.button>
            </div>
            <div class="col-12">
                <livewire:user.withdrawal.complete-withdrawal :method="$method" />
            </div>
        </div>
    @endif
</div>
