<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Cdn;
use UKFast\SDK\DDoSX\Entities\CdnRule;
use UKFast\SDK\SelfResponse;

class CdnClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const CDN_MAP = [];

    const RULES_MAP = [
        'cache_control' => 'cacheControl',
        'mime_types' => 'mimeTypes',
        'cache_control_duration' => 'cacheControlDuration'
    ];

    /**
     * @param Cdn $cdn
     * @return SelfResponse
     */
    public function create(Cdn $cdn)
    {
        $response = $this->post(
            'v1/domains/' . $cdn->name . '/cdn',
            json_encode($this->friendlyToApi($cdn, $this->requestMap))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "domain_name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Cdn($this->apiToFriendly($response->data, self::CDN_MAP));
            });
    }

    /**
     * Get a paginated list of cdn rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRules($domainName, $page = 1, $perPage = 15, $filters = [])
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
     * Get a rule for a domain by it's ID
     * @param $domainName
     * @param $ruleId
     * @return CdnRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleById($domainName, $ruleId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/cdn/rules/' . $ruleId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeCdnRule($body->data);
    }

    protected function serializeCdnRule($raw)
    {
        return new CdnRule($this->apiToFriendly($raw, self::RULES_MAP));
    }
}
