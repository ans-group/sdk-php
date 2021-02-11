<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafRule;

class WafRuleClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULE_MAP = [];

    /**
     * Get a paginated response of WAF Rules for a domain
     * @param $domainName
     * @param $page
     * @param $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/waf/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeRule($item);
        });

        return $page;
    }

    /**
     * Get the WAF Rule for a domain by its ID
     * @param $domainName
     * @param $ruleId
     * @return WafRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRule($body->data);
    }

    protected function serializeRule($raw)
    {
        return new WafRule($this->apiToFriendly($raw, self::RULE_MAP));
    }
}
