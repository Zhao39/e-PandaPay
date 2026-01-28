<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteChatIdRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/delete-id';
    }
}
