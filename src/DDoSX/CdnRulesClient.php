<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\DDoSX\Entities\CdnRule;

class CdnRulesClient extends Client
{
    const RULES_MAP = [
        'cache_control' => 'cacheControl',
        'mime_types' => 'mimeTypes',
        'cache_control_duration' => 'cacheControlDuration'
    ];

    /**
     * Get a paginated list of cdn rules for a domain
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
            'v1/domains/' . $domainName . '/cdn/rules',
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
     * Get a rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return CdnRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/cdn/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    protected function serializeData($raw)
    {
        return new CdnRule($this->apiToFriendly($raw, self::RULES_MAP));
    }
}
