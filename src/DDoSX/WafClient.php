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

    /**
     * @var string[]
     */
    protected $requestMap = [
        "domain_name"    => "name",
        "paranoia_level" => "paranoia"
    ];

    /**
     * @param Waf $waf
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Waf $waf)
    {
        $response = $this->post(
            'v1/domains/' . $waf->name . '/waf',
            json_encode($this->friendlyToApi($waf, $this->requestMap))
        );
        $body     = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeWaf($response->data);
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

        return $this->serializeWaf($body->data);
    }

    /**
     * @param $raw
     * @return Waf
     */
    protected function serializeWaf($raw)
    {
        return new Waf($this->apiToFriendly($raw, $this->requestMap));
    }
}
