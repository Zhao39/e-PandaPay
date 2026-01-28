<?php

namespace App\Http\Integrations\Solo;

use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;

class AssetPrices extends SoloRequest
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $coin)
    {
    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "https://api.brynamics.com/api/current-market-price/{$this->coin}usd";
    }
}
