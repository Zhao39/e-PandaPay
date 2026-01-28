@use('\Illuminate\Support\Number', 'Number')
<x-slot:title>
    Signal Subscribers
</x-slot:title>
<div>
    <x-breadcrumbs title=" Signal Subscribers">
        <li class="nav-item">
            <a href="#"> Signal Subscribers</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @isset($subscribers)
                        <div class="table-responsive">
                            <table class="table text-center table-hover">
                                <thead class="">
                                    <th>
                                        Subscriber
                                    </th>
                                    <th>
                                        Subscription
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Expiration
                                    </th>
                                    <th>
                                        Started At
                                    </th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($subscribers as $subscriber)
                                        <tr>
                                            <td>
                                                {{ $subscriber['user'] }}
                                            </td>
                                            <td>{{ $subscriber['subscription'] }}</td>
                                            <td>
                                                {{ Number::currency($subscriber['amount_paid'], $settings->s_currency) }}
                                            </td>
                                            <td>
                                                @if (now()->greaterThanOrEqualTo($subscriber['expired_at']))
                                                    <span class="text-danger">
                                                        {{ $subscriber['expired_at']->format('D d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-success">
                                                        {{ $subscriber['expired_at']->format('D d M Y') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $subscriber['created_at']->format('D d M Y') }}
                                            </td>
                                            <td>
                                                @if (is_null($subscriber['status']) || $subscriber['status'] == 'unbanned')
                                                    <button class="m-1 btn btn-warning btn-sm" wire:loading.attr='disabled'
                                                        wire:target="ban('{{ $subscriber['id'] }}')" data-toggle="modal"
                                                        data-target="#banModal"
                                                        wire:click="$set('subscriber_id', '{{ $subscriber['id'] }}')">
                                                        <x-spinner wire:loading
                                                            wire:target="ban('{{ $subscriber['id'] }}')" />
                                                        Ban from channel
                                                    </button>
                                                @else
                                                    <button class="m-1 btn btn-success btn-sm"
                                                        wire:click="unBan('{{ $subscriber['id'] }}')"
                                                        wire:confirm="Are you sure you want to unban this subscriber?"
                                                        wire:loading.attr='disabled'>
                                                        <x-spinner wire:loading
                                                            wire:target="unBan('{{ $subscriber['id'] }}')" />
                                                        Unban from channel
                                                    </button>
                                                @endif

                                                <button
                                                    wire:click.prevent="deleteSub('{{ $subscriber['id'] }}', '{{ $subscriber['user_id'] }}')"
                                                    class="m-1 btn btn-danger btn-sm"
                                                    wire:confirm="Are you sure you want to delete this subscription?"
                                                    wire:loading.attr='disabled'>
                                                    <x-spinner wire:loading
                                                        wire:target="deleteSub('{{ $subscriber['id'] }}', '{{ $subscriber['user_id'] }}')" />
                                                    Delete subscription
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <x-no-data />
                                                No Data Available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @include('components.pagination', ['route' => 'admin.signal.subscribers'])
                    @endisset
                    @empty($subscribers)
                        <div class="text-center">
                            <x-no-data />
                            <h5 class="font-weight-bold"> No Data Available</h5>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="banModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ban Subscriber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        When you ban a subscriber, the user will be removed from the channel and will not be able to
                        return to the channel on their own using
                        invite links, etc., unless unbanned first. <br>
                        <span class=" font-weight-bold">Note:</span>
                        If user is banned for more than 366 days or less than 30 seconds from the current time they are
                        considered to be banned forever.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" wire:click="ban('{{ $subscriber_id }}')"
                        data-dismiss="modal">Proceed</button>
                </div>
            </div>
        </div>
    </div>
</div>
