<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteCourseRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $id,
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/delete-course/{$this->id}";
    }
}
