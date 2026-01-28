<?php

namespace App\Http\Integrations\GetEPandaPay\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AddProfitRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        protected array $parameters,
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/manually-add-profit';
    }

    protected function defaultQuery(): array
    {
        return $this->parameters;
    }
}
