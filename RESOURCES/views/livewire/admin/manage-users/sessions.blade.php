<div class="col-12">
    <div class="card">
        <div class="card-body">
            @if (count($this->sessions) > 0)
                <table class="table">
                    <thead>
                        <th> User Agent</th>
                        <th> IP Address</th>
                        <th> Last Active</th>
                    </thead>
                    <tbody>
                        @foreach ($this->sessions as $session)
                            <tr>
                                <td>
                                    <span class="text-sm text-muted">
                                        @if ($session->agent->isDesktop())
                                            <i class="bi bi-display"></i>
                                        @else
                                            <i class="bi bi-phone"></i>
                                        @endif
                                        {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }}
                                        -
                                        {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                    </span>
                                </td>
                                <td>{{ $session->ip_address }}</td>

                                <td>{{ $session->last_active }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center">
                    <x-no-data />
                    <h4 class=" font-weight-bold">No Login Session</h4>
                </div>
            @endif
        </div>
    </div>
</div>
