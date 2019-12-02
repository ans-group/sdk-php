<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\LTaaS\Entities\Account;
use UKFast\SDK\SelfResponse;

class AccountClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Get the latest authorisation agreement
     * @param Account $account
     * @return SelfResponse
     * @throws GuzzleException
     */
    public function create(Account $account)
    {
        $response = $this->post('v1/accounts');

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return $this->serializeRequest($body->data);
            });
    }
}
