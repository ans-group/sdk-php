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
     *
     * @param       $domainName
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPageByDomain($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/waf/rulesets', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeRuleset($item);
        });

        return $page;
    }

    protected function serializeRuleset($raw)
    {
        return new WafRuleset($this->apiToFriendly($raw, self::RULESET_MAP));
    }
}
