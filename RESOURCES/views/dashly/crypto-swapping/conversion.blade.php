@use('\Illuminate\Support\Number', 'Number')
@push('styles')
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
    </style>
@endpush
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            Conversion
        </h1>
    </div>

    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit='convert' wire:confirm='Are you sure you want to carry out this conversion?'>
                        <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row">
                            <div class="form-group">
                                <div class="py-1">
                                    <span class="text-muted" style="font-size: 12px">
                                        @if ($from_is_account_balance)
                                            Balance:
                                            {{ Number::currency($from_balance, $settings->s_currency) }}
                                        @else
                                            Balance: {{ $from_balance }}
                                            {{ $from_currency->symbol }}
                                        @endif
                                    </span>
                                </div>
                                <label>From</label>
                                <div class="input-group position-relative">
                                    <input type="number" name="from_amount" wire:keyup='calculate'
                                        wire:model.live='from_amount' step="any" class="p-4 form-control" required>
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @if ($from_is_account_balance)
                                            Account Bal.
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img src="{{ $from_currency->logo_url }}" width="20"
                                                        class="rounded-full">
                                                </div>
                                                &nbsp;
                                                <div>
                                                    <p class="m-0"> {{ $from_currency->symbol }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end scrollable-menu">
                                        <a @class(['dropdown-item ', 'bg-light' => $from_is_account_balance]) href="#"
                                            wire:click.prevent="selectFromAsset('Account Balance')">
                                            <div>
                                                <p class="m-0">Account Balance</p>
                                                <small class="m-0 text-muted" style="font-size: 11px">
                                                    Account Balance
                                                </small>
                                            </div>
                                        </a>
                                        @foreach ($assets as $asset)
                                            <a @class([
                                                'dropdown-item',
                                                'bg-light' => $symbol == $asset['asset']->symbol,
                                            ]) href="#"
                                                wire:click.prevent="selectFromAsset('{{ $asset['asset']->symbol }}')">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <img src="{{ $asset['asset']->logo_url }}"
                                                            width="{{ $asset['asset']->logo_size }}"
                                                            class="rounded-full">
                                                    </div>
                                                    &nbsp;
                                                    <div>
                                                        <p class="m-0"> {{ $asset['asset']->symbol }}</p>
                                                        <small class="m-0 text-muted" style="font-size: 11px">
                                                            {{ $asset['asset']->name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    @error('from_amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <x-spinner wire:loading wire:target="selectFromAsset" />
                                <span class="">
                                    <b> Fees =
                                        {{ $settings->swap_fee }}%</b>
                                </span>
                            </div>
                            <div class="">
                                <i class="bi bi-arrow-down-up d-lg-none d-block text-dark font-weight-bold"
                                    style="font-size: 23px"></i>
                                <i class="bi bi-arrow-left-right d-lg-block d-none text-dark font-weight-bold"
                                    style="font-size: 23px"></i>
                            </div>
                            <div class="form-group">
                                <div class="py-1">
                                    <span class="text-muted" style="font-size: 12px">
                                        @if ($to_is_account_balance)
                                            Balance:
                                            {{ Number::currency($to_balance, $settings->s_currency) }}
                                        @else
                                            Balance: {{ $to_balance }}
                                            {{ $to_currency->symbol }}
                                        @endif
                                    </span>
                                </div>
                                <label>To</label>
                                <div class="input-group">
                                    <x-form.input type="number" name="to_amount" wire:model.live='to_amount'
                                        step="any" class="p-4" :readOnly="true" />
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @if ($to_is_account_balance)
                                            Account Bal.
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img src="{{ $to_currency->logo_url }}" width="20"
                                                        class="rounded-full">
                                                </div>
                                                &nbsp;
                                                <div>
                                                    <p class="m-0"> {{ $to_currency->symbol }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end scrollable-menu">
                                        <a @class(['dropdown-item ', 'bg-light' => $to_is_account_balance]) href="#"
                                            wire:click.prevent="selectToAsset('Account Balance')">
                                            <div>
                                                <p class="m-0">Account Balance</p>
                                                <small class="m-0 text-muted" style="font-size: 11px">
                                                    Account Balance
                                                </small>
                                            </div>
                                        </a>
                                        @foreach ($assets as $asset)
                                            <a @class([
                                                'dropdown-item',
                                                'bg-light' => $symbol == $asset['asset']->symbol,
                                            ]) href="#"
                                                wire:click.prevent="selectToAsset('{{ $asset['asset']->symbol }}')">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <img src="{{ $asset['asset']->logo_url }}"
                                                            width="{{ $asset['asset']->logo_size }}"
                                                            class="rounded-full">
                                                    </div>
                                                    &nbsp;
                                                    <div>
                                                        <p class="m-0"> {{ $asset['asset']->symbol }}</p>
                                                        <small class="m-0 text-muted" style="font-size: 11px">
                                                            {{ $asset['asset']->name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <x-spinner wire:loading wire:target="selectToAsset" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <x-ui.button class="px-5">
                                <x-spinner wire:loading wire:target="convert" />
                                Convert now
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
