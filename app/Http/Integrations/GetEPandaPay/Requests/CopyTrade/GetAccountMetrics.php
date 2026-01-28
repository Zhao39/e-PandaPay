<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\CopyTrade;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAccountMetrics extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(public readonly string $id, public readonly string $type)
    {
    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/account-metrics/{$this->id}/{$this->type}";
    }
}
