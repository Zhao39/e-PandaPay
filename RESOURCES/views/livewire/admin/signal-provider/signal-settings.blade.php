<x-slot:title>
    Signal Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Signal Settings">
        <li class="nav-item">
            <a href="#">Signal Settings</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form wire:submit.prevent='saveSettings'>
                                <div class="form-group">
                                    <label>Monthly Subscription Amount ({{ $settings->currency }})</label>
                                    <x-form.input type="number" step="any" wire:model='monthlyFee' />
                                </div>
                                <div class="form-group">
                                    <label>Quaterly Subscription Amount ({{ $settings->currency }})</label>
                                    <x-form.input type="number" step="any" wire:model='quaterlyFee' />
                                </div>
                                <div class="form-group">
                                    <label>Yearly Subscription Amount ({{ $settings->currency }})</label>
                                    <x-form.input type="number" step="any" wire:model='yearlyFee' />
                                </div>
                                <div class="form-group">
                                    <label>Chat ID</label>
                                    <div class="input-group">
                                        <x-form.input wire:model='chatId' readonly />
                                        <div class="input-group-append">
                                            @if ($chatId == '')
                                                <x-ui.button type='button' wire:click='getChatId'
                                                    wire:loading.attr='disabled' wire:target='getChatId'>
                                                    <x-spinner wire:loading wire:target="getChatId" />
                                                    Get ID
                                                </x-ui.button>
                                            @else
                                                <x-ui.button type='button' wire:click='deleteChatId'
                                                    wire:loading.attr='disabled' wire:target='deleteChatId'>
                                                    <x-spinner wire:loading wire:target="deleteChatId" />
                                                    Delete ID
                                                </x-ui.button>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($chatId == '')
                                        <small>
                                            Please make sure you have entered your telegram bot api and have
                                            sent at least one message on your private channel. Also make sure
                                            you have added the bot as an admin to the private channel, in order
                                            to retrieve the chat ID.
                                        </small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Telegram Bot API Token</label>
                                    <x-form.input wire:model='botToken' />
                                    <p>
                                        See how to <a href="https://core.telegram.org/bots/features#creating-a-new-bot"
                                            target="_blank">
                                            get your telegram bot api token
                                            <i class="bi bi-arrow-up-right"></i>
                                        </a>
                                    </p>
                                </div>
                                {{-- <div class="form-group">
                                    <label>Signal Message to be sent to telegram when published</label>
                                    <textarea class="form-control" wire:model='publish_message' rows="4"> </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Signal Message to be sent to telegram when you update result.</label>
                                    <textarea class="form-control" wire:model='result_message' rows="5"> </textarea>
                                </div> --}}
                                <div class="form-group">
                                    <button class="px-4 btn btn-primary" type="submit">
                                        <x-spinner wire:loading wire:target="saveSettings" />
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
