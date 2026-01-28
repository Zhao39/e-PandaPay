@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Withdrawal Transactions" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Withdrawal Transactions</a>
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
                                    <a class="nav-link " aria-current="page"
                                        href="{{ route('user.transactions.deposit') }}"
                                        @if ($settings->spa_mode) wire:navigate @endif>Deposits</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('user.transactions.withdrawal') }}"
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
                                    <div class="mt-3">
                                        {{ $this->withdrawals->links() }}
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
