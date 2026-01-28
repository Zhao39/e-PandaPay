<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class MembershipCategoryRequest extends Request
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
        return '/categories';
    }
}
