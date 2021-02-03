<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\MissedAttacksTotal;

class MissedAttacksClient extends Client
{
    const MISSED_ATTACK_TOTAL_MAP = [];

    /**
     * Get the total number of missed attacks
     * @param array $filters
     * @return MissedAttacksTotal
     */
    public function getTotal($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/missed-attacks/total' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    public function serializeResponse($data)
    {
        return new MissedAttacksTotal($this->apiToFriendly($data, self::MISSED_ATTACK_TOTAL_MAP));
    }
}
