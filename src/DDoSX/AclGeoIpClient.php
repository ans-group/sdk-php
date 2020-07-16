<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class AclGeoIpClient extends BaseClient
{
    protected $basePath = 'ddosx/';

    /**
     * Delete an ACL GeoIp Rule for a domain
     * @param $domainName
     * @param $geoIpRuleId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($domainName, $geoIpRuleId)
    {
        $response = $this->delete('v1/domains/' . $domainName . '/acls/geo-ips/' . $geoIpRuleId);
        return $response->getStatusCode() == 204;
    }
}
