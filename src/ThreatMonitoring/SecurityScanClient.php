<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\ThreatMonitoring\Entities\SecurityScan;

class SecurityScanClient extends Client
{
    const MAP = [
        'scan_scheduled' => 'scheduled',
        'scan_start' => 'scanStart',
        'scan_end' => 'scanEnd',
        'max_score' => 'maxScore'
    ];

    /**
     * Get the paginated response of security scans
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/scans', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });

        return $page;
    }

    /**
     * Get a security scan by its ID
     * @param $id
     * @return SecurityScan
     */
    public function getById($id)
    {
        $response = $this->get('v1/scans/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    /**
     * Serialize the response to use friendly names
     * @param $data
     * @return SecurityScan
     */
    public function serializeResponse($data)
    {
        return new SecurityScan($this->apiToFriendly($data, static::MAP));
    }
}
