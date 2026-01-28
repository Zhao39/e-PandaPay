<div>
    @if ($hasSubscribe)
        <div class="row">
            <div class="text-center col-12">
                <i class="fas fa-check-circle fa-4x text-success"></i>
                <div>
                    <div class="my-2 input-group">
                        <input type="text" class="form-control" wire:model='inviteLink' readonly>
                    </div>
                    <small class="d-block">
                        Copy and use your invite link. You can only used your invite link once and will not be
                        available again once this pages refreshes.
                    </small>
                    <a href="{{ route('user.tradeSignals', ['page' => '1']) }}" class="btn btn-primary btn-sm">
                        Finish copying
                    </a>
                </div>
            </div>
        </div>
    @else
        <form wire:submit='subscribe'>
            <div class="mb-3">
                <label for="">Choose Duration</label>
                <select class="form-select" wire:model.live='duration'>
                    <option value="Choose">Choose Duration</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Quarterly">Quarterly</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Amount ({{ $settings->currency }})</label>
                <x-form.input wire:model='amount' name="amount" :readOnly="true" />
                <small style="font-size: 10px">Amount will be deducted from your account balance.</small>
            </div>
            <div class="mb-3">
                <label for="">Telegram User ID</label>
                <x-form.input name="telegram_id" wire:model='telegram_id' required />
                <small style="font-size: 11px">Follow <a
                        href="https://medium.com/block-bastards/how-to-find-your-user-id-on-telegram-a27cb7b732d6"
                        target="_blank">this
                        guide to get your telegram user ID</a>.</small>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary">
                    <x-spinner wire:loading wire:target='subscribe' />
                    Subscribe
                </button>
            </div>
        </form>
    @endif
</div>
