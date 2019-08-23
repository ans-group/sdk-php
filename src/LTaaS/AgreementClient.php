<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\LTaaS\Entities\Agreement;
use UKFast\SDK\Page;

class AgreementClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Get the latest authorisation agreement
     * @return Agreement
     * @throws GuzzleException
     */
    public function latest()
    {
        $response = $this->get('v1/agreements/latest');

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Agreement($body->data);
    }
}
