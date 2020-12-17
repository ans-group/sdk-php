<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\AttackingIpsList;
use UKFast\SDK\ThreatMonitoring\Entities\AttackingIpsTotal;

class AttackingIpsClient extends Client
{
    const ATTACKING_IPS_TOTAL_MAP = [];
    const ATTACKING_IPS_LIST_MAP = [
        'source_ip' => 'sourceIp'
    ];

    /**
     * Get the total number of attacking ip addresses
     * @param array $filters
     * @return AttackingIpsTotal
     */
    public function getTotal($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/attacking-ips/unique/total' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeAttackingIpTotal($body->data);
    }


    /**
     * Get a list of the attacking ips
     * @param array $filters
     * @return array
     */
    public function getList($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/attacking-ips/unique/list' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeAttackingIpList($item);
        }, $body->data);
    }

    public function serializeAttackingIpTotal($data)
    {
        return new AttackingIpsTotal($this->apiToFriendly($data, static::ATTACKING_IPS_TOTAL_MAP));
    }

    public function serializeAttackingIpList($data)
    {
        return new AttackingIpsList($this->apiToFriendly($data, static::ATTACKING_IPS_LIST_MAP));
    }
}
