@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Transactions" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Transactions</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12" x-data="{ tab: 'deposit' }">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" x-bind:class="tab === 'deposit' ? 'active' : ''" aria-current="page"
                        href="#" @click.prevent="tab = 'deposit'">Deposits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" x-bind:class="tab === 'withdraw' ? 'active' : ''" href="#"
                        @click.prevent="tab = 'withdraw'">Withdrawals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" x-bind:class="tab === 'others' ? 'active' : ''"
                        @click.prevent="tab = 'others'">Others</a>
                </li>
            </ul>
            <div class="mt-3 tab-content">
                <div class="tab-pane fade show" x-show="tab === 'deposit'"
                    x-bind:class="tab === 'deposit' ? 'active' : ''" x-transition>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Payment mode</th>
                                            <th>Status</th>
                                            <th>Date created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($this->deposits as $deposit)
                                            <tr>
                                                <td>{{ Number::currency($deposit->amount, $settings->s_currency) }}</td>
                                                <td>{{ $deposit->payment_mode }}</td>
                                                <td>
                                                    @if ($deposit->status == 'Processed')
                                                        <span class="badge badge-success">{{ $deposit->status }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $deposit->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $deposit->created_at->toDayDateTimeString() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No record yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $this->deposits->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" x-show="tab === 'withdraw'"
                    x-bind:class="tab === 'withdraw' ? 'active' : ''" x-transition>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Amount requested</th>
                                            {{-- <th>Amount + charges</th> --}}
                                            <th>Recieving mode</th>
                                            <th>Status</th>
                                            <th>Date created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($this->withdrawals as $withdrawal)
                                            <tr>
                                                <td>
                                                    {{ Number::currency($withdrawal->amount, $settings->s_currency) }}
                                                </td>
                                                {{-- <td>
                                                 {{ Number::currency($withdrawal->to_deduct, $settings->s_currency) }}
                                            </td> --}}
                                                <td>{{ $withdrawal->payment_mode }}</td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'badge-warning' => $withdrawal->status == 'pending',
                                                        'badge-success' => $withdrawal->status == 'processed',
                                                        'badge-danger' => $withdrawal->status == 'cancelled',
                                                    ])>
                                                        {{ Str::ucfirst($withdrawal->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $withdrawal->created_at->toDayDateTimeString() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No record yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $this->withdrawals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" x-show="tab === 'others'"
                    x-bind:class="tab === 'others' ? 'active' : ''" x-transition>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="OthersTable" class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Narration</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($this->transactions as $history)
                                            <tr>
                                                <td>
                                                    {{ Number::currency($history->amount, $settings->s_currency) }}
                                                </td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'badge-success' => $history->type == 'Credit',
                                                        'badge-danger' => $history->type == 'Debit',
                                                    ])>
                                                        {{ $history->type }}
                                                    </span>
                                                </td>
                                                <td>{{ $history->narration }}</td>
                                                <td>
                                                    {{ $history->created_at->toDayDateTimeString() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No record yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $this->transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
