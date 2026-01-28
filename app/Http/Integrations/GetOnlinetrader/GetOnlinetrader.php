<?php

namespace App\Http\Integrations\GetEPandaPay;

use App\Models\Settings;
use App\Services\Website;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class GetEPandaPay extends Connector
{
    use AcceptsJson;
    private string | null $purchaseCode;
    private string $websiteUrl;
    private string | null $token;

    public function __construct()
    {
        $settings = Settings::find(1);
        $this->purchaseCode = $settings->purchase_code;
        $this->token = $settings->merchant_key;
        $this->websiteUrl = Website::url();
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://app.getonlinetrader.pro/api/v1';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'token' => $this->token,
            'X-Purchase-code' => $this->purchaseCode,
            'licenseKey' => $this->purchaseCode,
            'websiteUrl' => $this->websiteUrl,
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}