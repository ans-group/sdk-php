<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\AttackingCountriesList;

class AttackingCountriesClient extends Client
{
    const ATTACKING_COUNTRIES_TOP_BLOCKED_LIST_MAP = [];

    /**
     * Get a list of the top most blocked countries
     * @param array $filters
     * @return array
     */
    public function getTopBlockedList($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/attacking-countries/blocked/top' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeTopAttackingCountriesList($item);
        }, $body->data);
    }

    public function serializeTopAttackingCountriesList($data)
    {
        return new AttackingCountriesList(
            $this->apiToFriendly($data, static::ATTACKING_COUNTRIES_TOP_BLOCKED_LIST_MAP)
        );
    }
}
