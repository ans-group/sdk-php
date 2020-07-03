<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Waf;
use UKFast\SDK\DDoSX\Entities\WafAdvancedRule;
use UKFast\SDK\DDoSX\Entities\WafRule;
use UKFast\SDK\DDoSX\Entities\WafRuleset;
use UKFast\SDK\SelfResponse;

class WafClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULESET_MAP = [];

    /**
     * @param Waf $waf
     * @return SelfResponse
     */
    public function create(Waf $waf)
    {
        $response = $this->post(
            'v1/domains/' . $waf->name . '/waf',
            json_encode($this->friendlyToApi($waf, self::WAF_MAP))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Waf($this->apiToFriendly($response->data, self::WAF_MAP));
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

    protected function serializeWaf($raw)
    {
        return new Waf($this->apiToFriendly($raw, self::WAF_MAP));
    }
}
