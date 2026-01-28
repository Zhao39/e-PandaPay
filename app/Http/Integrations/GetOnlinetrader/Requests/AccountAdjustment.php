<?php

namespace App\Http\Integrations\GetEPandaPay\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AccountAdjustment extends Request
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
        return '/top-up';
    }

    protected function defaultQuery(): array
    {
        return $this->parameters;
    }

    protected function defaultHeaders(): array
    {
        return [
            'action' => 'typesystem',
        ];
    }
}
