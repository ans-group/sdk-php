<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\Page;
use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\ActiveResponseBlockedAttacks;

class ActiveResponseClient extends Client
{
    const ACTIVE_RESPONSE_BLOCKED_ATTACK_LIST_MAP = [
        'geolocation_ip' => 'ip',
        'abuseipdb_abuse_confidence_score' => 'abuse_confidence_score',
    ];

    /**
     * Get the total number of blocked attacks
     * @param int $page
     * @param int $per_page
     * @param array $filters
     * @return Page
     */
    public function getBlockedAttacksList($page = 1, $per_page = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/reports/active-response/blocked-attacks', $page, $per_page, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeBlockedAttackList($item);
        });

        return $page;
    }

    public function serializeBlockedAttackList($data)
    {
        $blockedAttack = new ActiveResponseBlockedAttacks($this->apiToFriendly($data, self::ACTIVE_RESPONSE_BLOCKED_ATTACK_LIST_MAP));
        $blockedAttack->syncOriginalAttributes();

        return $blockedAttack;
    }
}
