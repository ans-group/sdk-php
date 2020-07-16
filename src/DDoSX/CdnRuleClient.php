<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\CdnRule;

class CdnRuleClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULES_MAP = [
        'cache_control' => 'cacheControl',
        'mime_types' => 'mimeTypes',
        'cache_control_duration' => 'cacheControlDuration'
    ];

    /**
     * Get a paginated list of CDN Rules for a domain
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
            return $this->serializeCdnRule($item);
        });

        return $page;
    }

    /**
     * Get a CDN Rule for a domain by its ID
     * @param $domainName
     * @param $ruleId
     * @return CdnRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/cdn/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeCdnRule($body->data);
    }

    /**
     * @param $raw
     * @return CdnRule
     */
    protected function serializeCdnRule($raw)
    {
        return new CdnRule($this->apiToFriendly($raw, self::RULES_MAP));
    }
}