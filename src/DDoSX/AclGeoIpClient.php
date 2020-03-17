<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\AclGeoIp;
use UKFast\SDK\SelfResponse;

class AclGeoIpClient extends BaseClient
{
    protected $basePath = 'ddosx/';

    const MAP = [];

    /**
     * Update a GeoIp for a domain
     * @param $domainName
     * @param $geoIpId
     * @param $data
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($domainName, $geoIpId, $data)
    {
        $response = $this->patch(
            'v1/domains/' . $domainName . '/acls/geo-ips/' . $geoIpId,
            json_encode($this->friendlyToApi($data, self::MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeData($response->data);
            });
    }


    public function serializeData($raw)
    {
        return new AclGeoIp($this->apiToFriendly($raw, self::MAP));
    }
}
