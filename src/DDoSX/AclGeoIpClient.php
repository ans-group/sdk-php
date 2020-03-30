<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\AclGeoIp;
use UKFast\SDK\DDoSX\Entities\AclGeoIpMode;

class AclGeoIpClient extends BaseClient
{
    const GEOIPMAP = [];
    const MODEMAP = [];

    /**
     * Return a page of the ACL GeoIP rules for a domain
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
            'v1/domains/' . $domainName . '/acls/geo-ips',
            $page,
            $perPage,
            $filters
        );

        $page->serializeWith(function ($item) {
            return $this->serializeGeoIp($item);
        });

        return $page;
    }

    /**
     * Get a GeoIp rule for a domain by it's ID
     * @param $domainName
     * @param $geoIpId
     * @return AclGeoIp
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainName, $geoIpId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/acls/geo-ips/' .$geoIpId);

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeGeoIp($body->data);
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

        return $this->serializeMode($body->data);
    }

    protected function serializeGeoIp($raw)
    {
        return new AclGeoIp($this->apiToFriendly($raw, self::GEOIPMAP));
    }

    protected function serializeMode($raw)
    {
        return new AclGeoIpMode($this->apiToFriendly($raw, self::MODEMAP));
    }
}
