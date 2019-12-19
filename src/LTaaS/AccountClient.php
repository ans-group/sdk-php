<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\Loadbalancers\Entities\Frontend;
use UKFast\SDK\LTaaS\Entities\Account;
use UKFast\SDK\SelfResponse;

class AccountClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Get the latest authorisation agreement
     * @return SelfResponse
     * @throws GuzzleException
     */
    public function create()
    {
        $response = $this->post('v1/accounts');
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Account($response->data);
            });
    }
}
