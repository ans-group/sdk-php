<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class HstsRuleClient extends BaseClient
{
    /**
     * @var string $basePath
     */

    const RULE_MAP = [
        'max_age' => 'maxAge',
        'include_subdomains' => 'includeSubdomains',
        'record_name' => 'recordName'
    ];

    /**
     * Get a paginated list of HSTS rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/hsts/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeRules($item);
        });

        return $page;
    }

    /**
     * Get an individual HSTS rule for a domain
     * @param $domainName
     * @param $ruleId
     * @return \UKFast\SDK\DDoSX\Entities\HstsRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRules($body->data);
    }

    protected function serializeRules($raw)
    {
        return new \UKFast\SDK\DDoSX\Entities\HstsRule($this->apiToFriendly($raw, self::RULE_MAP));
    }
}
