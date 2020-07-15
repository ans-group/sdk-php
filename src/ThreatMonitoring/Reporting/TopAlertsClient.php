<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsList;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsType;

class TopAlertsClient extends Client
{
    const TOP_ALERTS_LIST_MAP = [];
    const TOP_ALERTS_TYPE_MAP = [];

    /**
     * Get a list of top alerts for a client
     * @param array $filters
     * @return array
     */
    public function getList($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/top-alerts/list' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeAttackingIpList($item);
        }, $body->data);
    }

    /**
     * Get a list of the type of top alerts along with a count for each
     * @param array $filters
     * @return array
     */
    public function getTypes($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/top-alerts/type' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeAttackingIpType($item);
        }, $body->data);
    }

    public function serializeAttackingIpList($data)
    {
        return new TopAlertsList($this->apiToFriendly($data, static::TOP_ALERTS_LIST_MAP));
    }

    public function serializeAttackingIpType($data)
    {
        return new TopAlertsType($this->apiToFriendly($data, static::TOP_ALERTS_TYPE_MAP));
    }
}
