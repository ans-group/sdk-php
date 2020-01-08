<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client;
use UKFast\SDK\DDoSX\Entities\Cdn;
use UKFast\SDK\SelfResponse;

class CdnClient extends Client
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    protected $requestMap = [];

    /**
     * @param Cdn $cdn
     * @return SelfResponse
     */
    public function create(Cdn $cdn)
    {
        $response = $this->post(
            'v1/domains/' . $cdn->name . '/cdn',
            json_encode($this->friendlyToApi($cdn, $this->requestMap))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Cdn($this->apiToFriendly($response->data[0], $this->requestMap));
            });
    }
}
