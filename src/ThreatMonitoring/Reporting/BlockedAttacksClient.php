<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\BlockedAttacksTotal;

class BlockedAttacksClient extends Client
{
    const BLOCKED_ATTACK_TOTAL_MAP = [];

    /**
     * Get the total number of blocked attacks
     * @param array $filters
     * @return BlockedAttacksTotal
     */
    public function getTotal($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/blocked-attacks/total' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    public function serializeResponse($data)
    {
        return new BlockedAttacksTotal($this->apiToFriendly($data, static::BLOCKED_ATTACK_TOTAL_MAP));
    }
}
