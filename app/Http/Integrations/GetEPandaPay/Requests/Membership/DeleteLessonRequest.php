<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteLessonRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::DELETE;

    public function __construct(protected readonly string $lessonId)
    {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "delete-lesson/{$this->lessonId}";
    }
}
