<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;


use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsList;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsType;

class ScaClient extends Client
{
    public function getSca($filters) : array
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        dd($queryParams);

    }
}
