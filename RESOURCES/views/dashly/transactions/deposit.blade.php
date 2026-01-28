@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <div>
        <!-- Title -->
        <h1 class="m-0 h2">
            Deposit Transactions
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="mt-5 row">
        <div class="col-6 col-lg-4">
            <!-- Card -->
            <a href="{{ route('user.transactions.deposit') }}" @if ($settings->spa_mode) wire:navigate @endif>
                <div @class([
                    'card',
                    'border-primary' => request()->routeIs('user.transactions.deposit'),
                ])>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column">
                                <h3 class="mb-0 card-title h4">Deposits</h3>
                                <span class="fs-6 text-dark">{{ $this->deposits->count() }} records</span>
                            </div>
                            <div class="avatar avatar-circle avatar-xs me-2">
                                <i class="bi bi-wallet-fill fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-4">
            <!-- Card -->
            <a href="{{ route('user.transactions.withdrawal') }}"
                @if ($settings->spa_mode) wire:navigate @endif>
                <div @class([
                    'card',
                    'border-primary' => request()->routeIs('user.transactions.withdrawal'),
                ])>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column">
                                <h3 class="mb-0 card-title h4">Withdrawals</h3>
                            </div>
                            <div class="avatar avatar-circle avatar-xs me-2">
                                <i class="bi bi-graph-down fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-4">
            <!-- Card -->
            <a href="{{ route('user.transactions.others') }}" @if ($settings->spa_mode) wire:navigate @endif>
                <div @class([
                    'card',
                    'border-primary' => request()->routeIs('user.transactions.others'),
                ])>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column">
                                <h3 class="mb-0 card-title h4">Others</h3>
                            </div>
                            <div class="avatar avatar-circle avatar-xs me-2">
                                <i class="bi bi-hourglass fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
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
                                        <td>{{ Number::currency($deposit->amount, $settings->s_currency) }}
                                        </td>
                                        <td>{{ $deposit->payment_mode }}</td>
                                        <td>
                                            @if ($deposit->status == 'Processed')
                                                <span class="badge bg-success">{{ $deposit->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $deposit->status }}</span>
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
                    <div class="mt-3">
                        {{ $this->deposits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
