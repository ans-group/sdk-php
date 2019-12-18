<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client;
use UKFast\SDK\DDoSX\Entities\Waf;
use UKFast\SDK\SelfResponse;

class WafClient extends Client
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    public $requestMap = [
        "domain_name" => "name",
        "paranoia_level" => "paranoia"
    ];

    /**
     * @param Waf $waf
     * @return SelfResponse
     */
    public function create(Waf $waf)
    {
        $response = $this->post(
            'v1/domains/' . $waf->name . '/waf',
            json_encode($this->friendlyToApi($waf, $this->requestMap))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Waf($this->apiToFriendly($response->data[0], $this->requestMap));
            });
    }
}
