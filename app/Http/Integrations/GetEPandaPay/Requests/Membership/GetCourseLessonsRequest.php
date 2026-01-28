<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCourseLessonsRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $course_id, protected readonly string $page)
    {
    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/courses-lessons/' . {$this->course_id}";
    }
    protected function defaultQuery(): array
    {
        return ['page' => $this->page, 'course_id' => $this->course_id];
    }
}
