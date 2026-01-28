<div>
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <p class="mb-0 text-white h3 font-weight-400">
                    {{ $coin->name }}({{ $coin->symbol }}) Details
                </p>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="mb-3 col-12">
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <a href="{{ route('user.swap.convert', ['coin' => $coin]) }}" class="btn btn-light btn-sm"
                        @if ($settings->spa_mode) wire:navigate @endif>
                        Convert
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
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
