@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="Swap History" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Swap History</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-light">
                                    <th>Source</th>
                                    <th>Destination</th>
                                    <th>Amount(src)</th>
                                    <th>Quantity(dest)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $tran)
                                    <tr>
                                        <td>{{ $tran->source }}</td>
                                        <td>{{ $tran->dest }}</td>
                                        <td>
                                            @if ($tran->source == 'Account Balance')
                                                {{ Number::currency(floatval($tran->amount), $settings->s_currency) }}
                                            @else
                                                {{ round(floatval($tran->amount), 8) }} {{ $tran->source }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($tran->dest == 'Account Balance')
                                                {{ Number::currency(floatval($tran->quantity), $settings->s_currency) }}
                                            @else
                                                {{ round(floatval($tran->quantity), 8) }} {{ $tran->dest }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $tran->created_at->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Record Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
