<?php

namespace UKFast\Account;

use UKFast\Account\Entities\Credit;

class CreditClient extends Client
{
    /**
     * Gets account credits
     *
     * @return Credit Array
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
