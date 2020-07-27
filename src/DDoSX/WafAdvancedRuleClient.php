<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafAdvancedRule;

class WafAdvancedRuleClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const WAF_ADVANCED_RULE_MAP = [];

    /**
     * Get a paginated response of WAF Advanced Rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest(
            'v1/domains/' . $domainName . '/waf/advanced-rules',
            $page,
            $perPage,
            $filters
        );

        $page->serializeWith(function ($item) {
            return $this->serializeWafAdvancedRule($item);
        });

        return $page;
    }

    /**
     * Get a WAF Advanced Rule for a domain by its ID
     * @param $domainName
     * @param $ruleId
     * @return WafAdvancedRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/advanced-rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeWafAdvancedRule($body->data);
    }

    protected function serializeWafAdvancedRule($raw)
    {
        return new WafAdvancedRule($this->apiToFriendly($raw, self::WAF_ADVANCED_RULE_MAP));
    }
}
