<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client;
use UKFast\SDK\DDoSX\Entities\WafRule;

class WafRulesClient extends Client
{
    protected $basePath = 'ddosx';

    const MAP = [];

    /**
     * Get a paginated response of rules for a domain
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
            return $this->serializeData($item);
        });

        return $page;
    }

    /**
     * Get the rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return WafRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    public function serializeData($raw)
    {
        return new WafRule($this->apiToFriendly($raw, self::MAP));
    }
}
