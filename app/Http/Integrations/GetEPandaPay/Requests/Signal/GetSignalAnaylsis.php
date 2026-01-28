<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSignalAnaylsis extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct() {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/get-analysis';
    }
}
