<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Cdn;
use UKFast\SDK\SelfResponse;

class CdnClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const CDN_MAP = [];

    /**
     * Create a new CDN for a domain
     *
     * @param Cdn $cdn
     * @return SelfResponse
     */
    public function create(Cdn $cdn)
    {
        $response = $this->post(
            'v1/domains/' . $cdn->name . '/cdn',
            json_encode($this->friendlyToApi($cdn, self::CDN_MAP))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Cdn($this->apiToFriendly($response->data, self::CDN_MAP));
            });
    }
}
