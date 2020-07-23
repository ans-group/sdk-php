<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\HstsStatus;
use UKFast\SDK\DDoSX\Entities\HstsRule;

class HstsClient extends BaseClient
{
    /**
     * @var string $basePath
     */
    protected $basePath = 'ddosx/';

    const STATUS_MAP = [];
    const RULE_MAP = [
        'max_age' => 'maxAge',
        'include_subdomains' => 'includeSubdomains',
        'record_name' => 'recordName'
    ];

    /**
     * Get the HSTS enabled status
     * @param $domainName
     * @return HstsStatus
     */
    public function getStatus($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts');
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeHstsStatus($body->data);
    }

    /**
     * Get a paginated list of HSTS Rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRulesPage($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/hsts/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeHstsRule($item);
        });

        return $page;
    }

    /**
     * Get an individual HSTS Rule for a domain
     * @param $domainName
     * @param $ruleId
     * @return \UKFast\SDK\DDoSX\Entities\HstsRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeHstsRule($body->data);
    }

    /**
     * @param $raw
     * @return HstsStatus
     */
    protected function serializeHstsStatus($raw)
    {
        return new HstsStatus($this->apiToFriendly($raw, self::STATUS_MAP));
    }

    /**
     * @param $raw
     * @return HstsRule
     */
    protected function serializeHstsRule($raw)
    {
        return new HstsRule($this->apiToFriendly($raw, self::RULE_MAP));
    }
}
