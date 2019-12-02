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
        $data = [
            'reseller_id' => $account->resellerId
        ];

        $response = $this->post('v1/accounts', json_encode($data));

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return $this->serializeRequest($body->data);
            });
    }
}
