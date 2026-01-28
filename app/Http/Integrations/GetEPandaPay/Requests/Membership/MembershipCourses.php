<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class MembershipCourses extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        protected string $page,
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/courses';
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
        ];
    }
}
