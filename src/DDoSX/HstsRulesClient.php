<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\DDoSX\Entities\HstsRule;

class HstsRulesClient extends Client
{
    const HSTS_RULE = [
        'max_age' => 'maxAge',
        'include_subdomains' => 'includeSubdomains',
        'record_name' => 'recordName'
    ];

    /**
     * Get a paginated list of hsts rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($domainName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/hsts/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeData($item);
        });

        return $page;
    }

    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    protected function serializeData($raw)
    {
        return new HstsRule($this->apiToFriendly($raw, self::HSTS_RULE));
    }
}
