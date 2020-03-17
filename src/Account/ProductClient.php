<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\Product;
use UKFast\SDK\Client as BaseClient;

class ProductClient extends BaseClient
{
    protected $basePath = 'account';
    const MAP = [];

    /**
     * Get a list of products for the specified account
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $response = $this->get('v1/products');
        $body = $this->decodeJson($response->getBody()->getContents());
        return array_map(function ($item) {
            return $this->serializeData($item);
        }, $body->data);
    }

    /**
     * @return Product
     */
    public function serializeData($raw)
    {
        return new Product($this->apiToFriendly($raw, self::MAP));
    }
}
