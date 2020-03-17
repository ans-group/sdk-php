<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class AclGeoIpClient extends BaseClient
{
    protected $basePath = 'ddosx/';


    /**
     * Delete a GeoIp for a domain
     * @param $domainName
     * @param $geoIpId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($domainName, $geoIpId)
    {
        $response = $this->delete('v1/domains/' . $domainName . '/acls/geo-ips/' . $geoIpId);
        return $response->getStatusCode() == 204;
    }
}
