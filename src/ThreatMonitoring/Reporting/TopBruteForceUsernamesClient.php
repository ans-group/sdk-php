<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\TopBruteForceUsernamesList;

class TopBruteForceUsernamesClient extends Client
{
    const TOP_BRUTE_FORCE_USERNAMES_LIST_MAP = [
        'source_user' => 'username'
    ];

    /**
     * Get the top 10 most commonly used brute force usernames
     * @param array $filters
     * @return TopBruteforceUsernamesList
     */
    public function getList($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/top-brute-force-usernames/list' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());
        return array_map(function ($item) {
            return $this->serializeTopBruteForceUsernamesList($item);
        }, $body->data);
    }

    public function serializeTopBruteForceUsernamesList($data)
    {
        return new TopBruteforceUsernamesList($this->apiToFriendly($data, static::TOP_BRUTE_FORCE_USERNAMES_LIST_MAP));
    }
}
