<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteSubscriberRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $id)
    {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/delete/user-sub/{$this->id}";
    }
}
