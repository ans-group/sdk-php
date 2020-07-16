<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\TopFilesChangedList;

class TopFilesChangedClient extends Client
{
    const TOP_FILES_CHANGED_MAP = [];

    /**
     * Get a list of the top changed files
     * @param array $filters
     * @return array
     */
    public function getList($filters = [])
    {
        $queryParams = '';

        if (count($filters) > 0) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/top-files-changed' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeTopFilesChangedList($item);
        }, $body->data);
    }

    public function serializeTopFilesChangedList($data)
    {
        return new TopFilesChangedList($this->apiToFriendly($data, static::TOP_FILES_CHANGED_MAP));
    }
}
