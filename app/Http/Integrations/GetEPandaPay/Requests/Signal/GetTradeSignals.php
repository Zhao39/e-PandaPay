<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTradeSignals extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $page)
    {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/trading-signals';
    }

    protected function defaultQuery(): array
    {
        return ['page' => $this->page];
    }
}
