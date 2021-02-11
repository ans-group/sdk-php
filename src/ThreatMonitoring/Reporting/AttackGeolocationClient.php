<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\GeolocationData;

class AttackGeolocationClient extends Client
{
    const DEFAULT_VALUES = [
        'precision' => 3,
        'nwLat' => 61.77312286453146,
        'nwLng' => -168.75000000000003,
        'seLat' => -61.77312286453146,
        'seLng' => 168.75000000000003
    ];

    const GEOLOCATION_FILTER_MAP = [
        'north_west_lat' => 'nwLat',
        'north_west_lng' => 'nwLng',
        'south_east_lat' => 'seLat',
        'south_east_lng' => 'seLng'
    ];
    const GEOLOCATION_MAP = [];


    /**
     * Get a list of the geolocation attack data
     * @param array $filters
     * @return array
     */
    public function getList($filters = [])
    {
        $queryParams = '';

        $filters = $this->setDefaults($filters);
        $filters = $this->friendlyToApi($filters, self::GEOLOCATION_FILTER_MAP);

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/attack-geolocation' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeGeolocationData($item);
        }, $body->data);
    }

    /**
     * Check if the required additional params are in the filter
     * @param $filters
     * @return mixed
     */
    public function setDefaults($filters)
    {
        foreach (self::DEFAULT_VALUES as $key => $value) {
            if (! array_key_exists($key, $filters)) {
                $filters[$key] = $value;
            }
        }

        return $filters;
    }

    public function serializeGeolocationData($data)
    {
        return new GeolocationData($this->apiToFriendly($data, static::GEOLOCATION_MAP));
    }
}
