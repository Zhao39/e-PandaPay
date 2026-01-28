<div class="mb-5 row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                Process Withdrawal Request
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if ($withdrawal->status == 'pending')
                        <h4>
                            Send Funds to {{ $withdrawal->user->name }} through his payment details below
                        </h4>
                    @elseif($withdrawal->status == 'cancelled')
                        <h4 class="text-danger">Payment Cancelled</h4>
                    @else
                        <h4 class="text-success">Payment Completed</h4>
                    @endif
                </div>
                <div>
                    @if ($method->default_pay)
                        @if ($withdrawal->payment_mode == 'Bitcoin')
                            <div class="mb-3 form-group">
                                <h5 class="">BTC Address</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->btc_address }}" readonly>
                            </div>
                        @elseif($withdrawal->payment_mode == 'Ethereum')
                            <div class="mb-3 form-group">
                                <h5 class="">ETH Address</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->eth_address }}" readonly>
                            </div>
                        @elseif($withdrawal->payment_mode == 'Litecoin')
                            <div class="mb-3 form-group">
                                <h5 class="">LTC Address</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->ltc_address }}" readonly>
                            </div>
                        @elseif ($withdrawal->payment_mode == 'USDT')
                            <h5 class="">USDT Address</h5>
                            <input type="text" class="form-control readonly "
                                value="{{ $withdrawal->user->usdt_address }}" readonly>
                        @elseif ($withdrawal->payment_mode == 'BUSD')
                            <h5 class="">BUSD Address</h5>
                            <input type="text" class="form-control readonly " value="{{ $withdrawal->paydetails }}"
                                readonly>
                        @elseif($withdrawal->payment_mode == 'Bank Transfer')
                            <div class="mb-3 form-group">
                                <h5 class="">Bank Name</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->bank_name }}" readonly>
                            </div>
                            <div class="mb-3 form-group">
                                <h5 class="">Account Name</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->account_name }}" readonly>
                            </div>
                            <div class="mb-3 form-group">
                                <h5 class="">Account Number</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->user->account_number }}" readonly>
                            </div>
                            @if (!empty($withdrawal->user->swift_code))
                                <div class="mb-3 form-group">
                                    <h5 class="">Swift Code</h5>
                                    <input type="text" class="form-control readonly "
                                        value="{{ $withdrawal->user->swift_code }}" readonly>
                                </div>
                            @endif
                        @endif
                    @else
                        @if ($method->methodtype == 'crypto')
                            <div class="mb-3 form-group">
                                <h5 class="">{{ $withdrawal->payment_mode }} Address</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->paydetails }}" readonly>
                            </div>
                        @else
                            <div class="mb-3 form-group">
                                <h5 class="">{{ $withdrawal->payment_mode }} Payment Details</h5>
                                <input type="text" class="form-control readonly "
                                    value="{{ $withdrawal->paydetails }}" readonly>
                            </div>
                        @endif
                    @endif
                    @if ($withdrawal->status == 'processed' || $withdrawal->status == 'cancelled')
                        <x-ui.button type="button" class="btn-info" wire:click="$parent.cancel">
                            Cancel
                        </x-ui.button>
                    @endif
                </div>
                @if ($withdrawal->status == 'pending')
                    <div class="mt-1" x-data="{
                        action: @entangle('action'),
                        sendEmail: false,
                    }">
                        <form wire:submit='processWithrdawal' method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <h6 class="">Action</h6>
                                    <select x-model='action' name="action" wire:model="action"
                                        class="mb-2 form-control">
                                        <option value="Paid">Paid</option>
                                        <option value="Reject">Reject</option>
                                    </select>
                                </div>

                                {{-- <div class="col-md-12 form-group" x-show="action == 'Reject'" style="display: none">
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="emailsend" wire:model='emailsend' value="false"
                                                class="selectgroup-input" @click="sendEmail = false">
                                            <span class="selectgroup-button">Don't Send Email</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="emailsend" wire:model='emailsend' value="true"
                                                class="selectgroup-input" @click="sendEmail = true">
                                            <span class="selectgroup-button">Send Email</span>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="form-row" x-show="sendEmail && action == 'Reject'">
                                <div class="form-group col-md-12">
                                    <h6>Subject</h6>
                                    <x-form.input name='subject' wire:model='subject' />
                                </div>
                                <div class="form-group col-md-12">
                                    <h6>Enter Reasons for rejecting this withdrawal request</h6>
                                    <textarea class="form-control" row="3" placeholder="Type in here" wire:model='message' name="reason"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    @can('process withdrawals')
                                        <x-ui.button>
                                            <x-spinner wire:loading wire:target="processWithrdawal" />
                                            Proccess
                                        </x-ui.button>
                                    @endcan
                                    <x-ui.button type="button" class="btn-info" wire:click="$parent.cancel">
                                        Cancel
                                    </x-ui.button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
