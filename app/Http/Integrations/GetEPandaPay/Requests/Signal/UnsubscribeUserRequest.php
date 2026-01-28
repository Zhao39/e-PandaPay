<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class UnsubscribeUserRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        protected array $data,
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/chat-member-ban';
    }

    protected function defaultQuery(): array
    {
        return $this->data;
    }
}
