<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\TldCategory;

class TldCategoryClient extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Gets every TLD category in the catalogue. The endpoint is not paginated or filterable, and each category
     * exposes only its name.
     *
     * @return TldCategory[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $response = $this->get('v2/tld-categories');
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return new TldCategory((array) $item);
        }, $body->data);
    }
}
