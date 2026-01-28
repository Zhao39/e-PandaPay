@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Deposit Transactions" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Deposit Transactions</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ route('user.transactions.deposit') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>Deposits</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.transactions.withdrawal') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>Withdrawals</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.transactions.others') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>Others</a>
                                </li>
                            </ul>
                            <div class="mt-3 tab-content">
                                <div class="tab-pane fade show active">
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
                                                                <span
                                                                    class="badge badge-success">{{ $deposit->status }}</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-danger">{{ $deposit->status }}</span>
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
            </div>
        </div>
    </div>
</div>
