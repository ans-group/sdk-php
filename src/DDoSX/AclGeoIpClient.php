<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\AclGeoIpRule;
use UKFast\SDK\SelfResponse;

class AclGeoIpClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    const RULE_MAP = [];

    /**
     * Update a ACL GeoIp Rule for a domain
     * @param $domainName
     * @param $geoIpRuleId
     * @param $geoIpRule
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateRule($domainName, $geoIpRuleId, $geoIpRule)
    {
        $response = $this->patch(
            'v1/domains/' . $domainName . '/acls/geo-ips/' . $geoIpRuleId,
            json_encode($this->friendlyToApi($geoIpRule, self::RULE_MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeGeoIpRule($response->data);
            });
    }

    /**
     * @param $raw
     * @return AclGeoIpRule
     */
    public function serializeGeoIpRule($raw)
    {
        return new AclGeoIpRule($this->apiToFriendly($raw, self::RULE_MAP));
    }

    /**
     * Delete an ACL GeoIp Rule for a domain
     * @param $domainName
     * @param $geoIpRuleId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroyRule($domainName, $geoIpRuleId)
    {
        $response = $this->delete('v1/domains/' . $domainName . '/acls/geo-ips/' . $geoIpRuleId);
        return $response->getStatusCode() == 204;
    }
}
