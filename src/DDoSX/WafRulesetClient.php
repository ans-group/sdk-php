<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client;
use UKFast\SDK\DDoSX\Entities\WafRuleset;

class WafRulesetClient extends Client
{
    const MAP = [];

    /**
     * Get the rulesets for a domain
     * @param $domainName
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDomainName($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rulesets');

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeData($item);
        }, $body->data);
    }

    protected function serializeData($raw)
    {
        return new WafRuleset($this->apiToFriendly($raw, self::MAP));
    }
}
