<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\Signal;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class SaveAnalysis extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $data,
    ) {}
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/save-analysis';
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
