<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafRuleset;

class WafRulesetClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULESET_MAP = [];

    /**
     * Get the WAF Rulesets for a domain
     * @param $domainName
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRulesets($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rulesets');

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeRuleset($item);
        }, $body->data);
    }

    protected function serializeRuleset($raw)
    {
        return new WafRuleset($this->apiToFriendly($raw, self::RULESET_MAP));
    }
}