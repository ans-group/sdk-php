<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\DDoSX\Client;
use UKFast\SDK\DDoSX\Entities\WafAdvancedRule;

class WafAdvancedRulesClient extends Client
{
    protected $basePath = 'ddosx';

    const MAP = [];

    /**
     * Get a paginated response of advanced rules for a domain
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
            return $this->serializeData($item);
        });

        return $page;
    }

    /**
     * Get an advanced rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return WafAdvancedRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/waf/advanced-rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    public function serializeData($raw)
    {
        return new WafAdvancedRule($this->apiToFriendly($raw, self::MAP));
    }
}
