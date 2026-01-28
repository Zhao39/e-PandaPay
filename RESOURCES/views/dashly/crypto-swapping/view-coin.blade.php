<div>
    <div class="mb-5">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <div>
                    <img src="{{ $coin->logo_url }}" width="{{ $coin->logo_size }}" class="rounded-full">
                </div>
                &nbsp;
                <div>
                    <h3 class="m-0 font-weight-bold"> {{ $coin->name }}({{ $coin->symbol }})</h3>
                    <h3 class="text-primary">
                        ${{ $coin->price_in_usd }}
                    </h3>
                </div>
            </div>
            <div>
                <a href="{{ route('user.swap.convert', ['coin' => $coin]) }}" class="btn btn-primary btn-sm"
                    @if ($settings->spa_mode) wire:navigate @endif>
                    Convert
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">

        <div class="col-12">
            <div class="tradingview-widget-container">
                <div id="tradingview_f933e"></div>
                <div class="tradingview-widget-copyright">

                    <script type="text/javascript">
                        new TradingView.widget({
                            "width": "100%",
                            "height": "550",
                            "symbol": "COINBASE:{{ $coin->symbol }}USD",
                            "interval": "1",
                            "timezone": "Etc/UTC",
                            "theme": 'light',
                            "style": "9",
                            "locale": "en",
                            "toolbar_bg": "{{ $settings->website_theme }}",
                            "enable_publishing": false,
                            "hide_side_toolbar": false,
                            "allow_symbol_change": true,
                            "calendar": false,
                            "studies": [
                                "BB@tv-basicstudies"
                            ],
                            "container_id": "tradingview_f933e"
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
