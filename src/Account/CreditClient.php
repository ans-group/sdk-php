<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client;
use UKFast\SDK\Account\Entities\Credit;

class CreditClient extends Client
{
    protected $basePath = 'account/';

    /**
     * Gets account credits
     *
     * @return Credit Array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $response = $this->request("GET", "v1/credits");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return new Credit($item);
        }, $body->data);
    }
}
