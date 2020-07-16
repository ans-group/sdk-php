<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\AclGeoIpRule;
use UKFast\SDK\DDoSX\Entities\AclGeoIpMode;

class AclGeoIpClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULE_MAP = [];
    const MODE_MAP = [];

    /**
     * Return a page of the ACL GeoIP rules for a domain
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRulesPage($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest(
            'v1/domains/' . $domainName . '/acls/geo-ips',
            $page,
            $perPage,
            $filters
        );

        $page->serializeWith(function ($item) {
            return $this->serializeGeoIpRule($item);
        });

        return $page;
    }

    /**
     * Get a GeoIp rule for a domain by its ID
     * @param $domainName
     * @param $geoIpId
     * @return AclGeoIpRule
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleById($domainName, $geoIpId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/acls/geo-ips/' .$geoIpId);

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeGeoIpRule($body->data);
    }

    /**
     * Get the current GeoIp Mode for a domain
     * @param $domainName
     * @return AclGeoIpMode
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMode($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/acls/geo-ips/mode');

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeGeoIpMode($body->data);
    }

    /**
     * @param $raw
     * @return AclGeoIpRule
     */
    protected function serializeGeoIpRule($raw)
    {
        return new AclGeoIpRule($this->apiToFriendly($raw, self::RULE_MAP));
    }

    /**
     * @param $raw
     * @return AclGeoIpMode
     */
    protected function serializeGeoIpMode($raw)
    {
        return new AclGeoIpMode($this->apiToFriendly($raw, self::MODE_MAP));
    }
}
