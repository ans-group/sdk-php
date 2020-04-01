<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\DDoSX\Entities\Hsts;
use UKFast\SDK\DDoSX\Entities\HstsRule;

class HstsClient extends Client
{
    const HSTS_MAP = [];
    const HSTS_RULE_MAP = [
        'max_age' => 'maxAge',
        'include_subdomains' => 'includeSubdomains',
        'record_name' => 'recordName'
    ];

    public function getStatus($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts');
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeHsts($body->data);
    }

    /**
     * Get a paginated list of hsts rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRules($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/hsts/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeRules($item);
        });

        return $page;
    }

    /**
     * Get an individual hsts rule for a domain
     * @param $domainName
     * @param $ruleId
     * @return HstsRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRules($body->data);
    }

    protected function serializeHsts($raw)
    {
        return (new Hsts($this->apiToFriendly($raw, self::HSTS_MAP)));
    }

    protected function serializeRules($raw)
    {
        return new HstsRule($this->apiToFriendly($raw, self::HSTS_RULE_MAP));
    }
}
