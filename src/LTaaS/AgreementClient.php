<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\LTaaS\Entities\Agreement;

class AgreementClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Get the latest authorisation agreement
     * @param $type
     * @return Agreement
     * @throws GuzzleException
     */
    public function latestByType($type)
    {
        $response = $this->get('v1/agreements/latest/' . $type);

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Agreement($body->data);
    }
}
