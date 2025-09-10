<?php

namespace App\Http\Integrations\TwitterAPI\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAdvancedSearchRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $q, protected readonly string $cursor = '')
    {
        //
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/twitter/tweet/advanced_search';
    }

    protected function defaultQuery(): array
    {
        return [
            'query' => $this->q,
            'cursor' => $this->cursor,
            'queryType' => 'Latest',
        ];
    }
}
