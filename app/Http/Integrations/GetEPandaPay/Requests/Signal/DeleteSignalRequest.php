<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteSignalRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $signalId)
    {
    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/delete-signal/{$this->signalId}";
    }
}
