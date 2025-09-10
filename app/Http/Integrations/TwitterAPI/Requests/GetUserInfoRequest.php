<?php

namespace App\Http\Integrations\TwitterAPI\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUserInfoRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $username) {
        //
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/twitter/user/info';
    }

    protected function defaultQuery(): array
    {
        return [
            'userName' => $this->username,
        ];
    }
}
