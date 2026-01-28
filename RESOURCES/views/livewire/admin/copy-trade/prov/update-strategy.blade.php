<div x-data="{
    mode: @entangle('strategy_mode'),
    modeinfo: '',
    optionTitle: '',
    modename() {
        if (this.mode == 'none') {
            this.modeinfo = 'If value is none, then trade size will be preserved irregardless of the subscriber balance.';
        }
        if (this.mode == 'contractSize') {
            this.modeinfo = 'If value is contractSize, then trade size will be scaled according to contract size.';
        }
        if (this.mode == 'balance') {
            this.modeinfo = 'If set to balance, the trade size on strategy subscriber will be scaled according to balance to preserve risk.';
        }
        if (this.mode == 'equity') {
            this.modeinfo = 'If set to equity, the trade size on strategy subscriber will be scaled according to subscriber equity.';
        }
        if (this.mode == 'fixedVolume') {
            this.modeinfo = 'If fixedVolume is set, then trade will be copied with a fixed volume of tradeVolume setting.';
            this.optionTitle = 'Enter Fixed trade volume';
        }
        if (this.mode == 'fixedRisk') {
            this.modeinfo = 'Note, that in fixedRisk mode trades without a SL are not copied.';
            this.optionTitle = 'Enter Fixed risk fraction';
        }
        if (this.mode == 'expression') {
            this.modeinfo = 'If expression is set, then trade volume will be calculated using a user-defined expression. Note, that expression trade size scaling mode is intended for advanced users and we DO NOT RECOMMEND using it unless you understand what are you doing, as mistakes in expression can result in loss. Math.js expression will be used to calculate trade volume (see https://mathjs.org/docs/expressions/syntax.html). Following variables are available in expression scope: providerVolume - provider signal trade size; providerTradeAmount - provider signal trade value in trade copier base curency; multiplier - subscription multiplier value; providerBalance - provider balance value in trade copier base currency; balance - subscriber balance value in trade copier base currency; quoteOrOpenPrice - current asset price (for market orders) or open price (for pending orders) on subscriber side; tickValue - current asset tick value on subscriber side expressed in trade copier base currency; tickSize - tick size on subscriber side; providerScaledVolume - provider trade volume multiplied by provider contract size; contractSize - subscriber contract size; providerStopLoss - provider signal stop loss price; providerTakeProfit - provider signal take profit price; accountCurrencyExchangeRate - subscriber exchange rate of account currency to trade copier base currency';
            this.optionTitle = 'Enter math.js expression';
        }
    },
    init() {
        $watch('mode', value => this.modename())
        this.modename();
    }
}">
    <form wire:submit='save'>
        <div class="mb-2">
            <label>Strategy Name</label>
            <x-form.input name="name" wire:model='strategy_name' placeholder="Strategy Name" required />
        </div>
        <div class="mb-2">
            <label>Strategy Description</label>
            <x-form.input name="strategy_description" wire:model='strategy_description' required />
        </div>
        <div class="mb-2">
            <label>Trade Size Mode</label>
            <select x-model='mode' class="form-control" name="strategy_mode" wire:model='strategy_mode'>
                @foreach ($modes as $mode)
                    <option value="{{ $mode }}">{{ $mode }}</option>
                @endforeach
            </select>
            <small x-text='modeinfo' style="font-size: 10px"></small>
        </div>
        <div class="mb-2" x-show="mode == 'fixedVolume' || mode == 'fixedRisk' || mode == 'expression'">
            <label x-text='optionTitle'></label>
            <x-form.input name="modecompliment" wire:model='modecompliment'
                x-bind:required="mode == 'fixedVolume' || mode == 'fixedRisk' || mode == 'expression'"
                placeholder="Enter value here" />
        </div>
        <div x-data="{ publish: @entangle('publish_to_telegram') }">
            <div class="pl-4 mb-2">
                <input class="form-check-input" type="checkbox" x-model="publish" name="publishsignal">
                <label class="form-check-label">
                    Publish trades to a Telegram channel
                </label>
            </div>
            <div class="mb-2" x-show="publish">
                <label>Telegram Bot Token</label>
                <x-form.input name="bot_token" wire:model='bot_token' x-bind:required="publish" />
            </div>
            <div class="mb-2" x-show="publish">
                <label>Telegram Chat ID</label>
                <x-form.input name="chat_id" wire:model='chat_id' x-bind:required="publish" />
            </div>

            <div class="mb-2" x-show="publish">
                <small style="font-size: 12px">
                    In order to publish your strategy trades to a Telegram channel,
                    please:
                </small> <br>
                <small style="font-size: 12px"> - Create telegram bot via BotFather (<a
                        href="https://app.getonlinetrader.pro/doc/How-to-create-a-telegram-bot" target="_blank">see
                        this doc
                    </a>)
                </small> <br>
                <small style="font-size: 12px">
                    - Make your bot an administrator of the channel you are going to
                    publish the trades to.
                </small> <br>
                <small style="font-size: 12px">
                    - Configure your CopyFactory strategy to publish trades via Telegram
                    (see form above).
                </small>
            </div>
        </div>
        <div class="mt-3">
            <x-ui.button type="button" wire:click="$parent.cancelUpdate()"
                class="border btn-light">Cancel</x-ui.button>
            <x-ui.button>
                <x-spinner wire:loading wire:target="save" />
                Save
            </x-ui.button>
        </div>
    </form>
</div>
