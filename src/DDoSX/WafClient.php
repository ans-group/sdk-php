<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Waf;
use UKFast\SDK\SelfResponse;

class WafClient extends BaseClient
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
                return new Waf($this->apiToFriendly($response->data, $this->requestMap));
            });
    }

    /**
     * Gets the WAF settings for the domain
     * @param $domainName
     * @return Waf
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDomainName($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf');

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    public function serializeData($raw)
    {
        return new Waf($this->apiToFriendly($raw, $this->requestMap));
    }
}
