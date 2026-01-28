<?php

namespace App\Http\Integrations\GetEPandaPay\Requests\CopyTrade;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class MakePaymentRequest extends Request implements HasBody
{
    use HasJsonBody;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
        protected array $data,
    ) {
    }
    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/save-payment';
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
