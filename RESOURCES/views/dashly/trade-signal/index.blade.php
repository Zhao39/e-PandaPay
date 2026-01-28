@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <h1 class="h2">
        Trade Signal Provider
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (!$subscription)
                                <div class="py-4 text-center">
                                    <x-no-data />
                                    <p>You do not have have a subscription</p>
                                    <button type="button" class="px-4 btn btn-primary btn-sm"" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Subscribe Now
                                    </button>
                                </div>
                            @else
                                @if ($subscription['status'] == 'banned')
                                    <div class="text-center">
                                        <x-no-data />
                                        <p>Your subscription has been banned</p>
                                        <p>Please contact support</p>
                                        <a href="{{ route('user.contactsupport') }}" class="btn btn-primary btn-sm"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            Contact
                                        </a>
                                    </div>
                                @else
                                    <div class="d-lg-flex justify-content-between">
                                        <div>
                                            <h3 class="font-weight-bold h5">{{ $subscription['subscription'] }}
                                                Subscription
                                            </h3>
                                            <h2 class="text-muted">
                                                <b> {{ $settings->currency . $subscription['amount_paid'] }}</b>
                                            </h2>
                                        </div>
                                        <div class="mt-3 mt-lg-0">
                                            <small class="text-danger">Expiring</small>
                                            <p class="m-0">
                                                {{ \Carbon\Carbon::parse($subscription['expired_at'])->inUserTimezone()->toDayDateTimeString() }}
                                            </p>

                                            @if (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription['reminded_at'])) ||
                                                    now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription['expired_at'])))
                                                <div class="mt-2">
                                                    @php
                                                        if ($subscription['subscription'] == 'Monthly') {
                                                            $fee = $set['signal_monthly_fee'];
                                                        } elseif ($subscription['subscription'] == 'Quarterly') {
                                                            $fee = $set['signal_quarterly_fee'];
                                                        } else {
                                                            $fee = $set['signal_yearly_fee'];
                                                        }
                                                    @endphp
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        wire:confirm="You will be charged {{ $settings->currency . $fee }} for this subscription renewal"
                                                        wire:click="renew('{{ $fee }}')"
                                                        wire:loading.attr="disabled">
                                                        <x-spinner wire:loading wire:target="renew" />
                                                        Renew Subscription
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-5">
                                        <h4 class="font-weight-bold">Trade Signals</h4>
                                        <div class="mt-2 table-responsive">
                                            <table class="table table-hover">
                                                <thead class="bg-light">
                                                    <th>Ref</th>
                                                    <th>Order Type</th>
                                                    <th>Currency</th>
                                                    <th>Price</th>
                                                    <th>Take Profit-1</th>
                                                    <th>Take Profit-2</th>
                                                    <th>Stop Loss</th>
                                                    <th>Result</th>
                                                    <th>Date</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($signals as $signal)
                                                        <tr>
                                                            <td>#{{ $signal['reference'] }}</td>
                                                            <td> {{ $signal['trade_direction'] }}</td>
                                                            <td>{{ $signal['currency_pair'] }}</td>
                                                            <td>{{ $signal['price'] }}</td>
                                                            <td>{{ $signal['take_profit1'] }}</td>
                                                            <td>
                                                                {{ $signal['take_profit2'] ? $signal['take_profit2'] : '-' }}
                                                            </td>
                                                            <td>{{ $signal['stop_loss1'] }}</td>
                                                            <td>{{ $signal['result'] ? $signal['result'] : '-' }}</td>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($signal['created_at'])->inUserTimezone()->format('d M Y') }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">
                                                                <x-no-data />
                                                                No Data Available
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        @include('components.pagination', ['route' => 'user.tradeSignals'])
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Subscribe Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalCenterTitle">Subscribe
                        to signal provider</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:user.trade-signal.subscribe lazy />
                </div>
            </div>
        </div>
    </div>
</div>
