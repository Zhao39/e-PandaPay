<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Membership;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class AddCategoryRequest extends Request implements HasBody
{
    use HasJsonBody;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        protected string $category_name,
    ) {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/add-category';
    }

    protected function defaultBody(): array
    {
        return [
            'category' => $this->category_name,
        ];
    }
}
