<?php

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\ThreatMonitoring\Entities\ScanResults;
use UKFast\SDK\ThreatMonitoring\Entities\Vulnerability;

class ScanResultsClient extends Client
{
    const RESULTS_MAP = [
        'scan_id' => 'scanId',
        'scan_start' => 'scanStart',
        'scan_end' => 'scanEnd',
        'mac_address' => 'macAddress',
        'max_score' => 'maxScore'
    ];

    const VULNERBILITY_MAP = [
        'risk_factor' => 'riskFactor',
        'cvss_vector' => 'cvssVector',
        'cvss_base_score' => 'cvssBaseScore'
    ];

    /**
     * Get a paginated response of results by the scanId
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/scans/' . $id . '/results', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });

        return $page;
    }

    /**
     * serialize the data returned from the API
     * @param $data
     * @return ScanResults
     */
    public function serializeResponse($data)
    {
        $vulnerabilities = [];

        if (count($data->vulnerabilities) > 0) {
            foreach ($data->vulnerabilities as $vulnerability) {
                $vulnerabilities[] = new Vulnerability($this->apiToFriendly($vulnerability, self::VULNERBILITY_MAP));
            }
        }

        $data->vulnerabilities = $vulnerabilities;

        return new ScanResults($this->apiToFriendly($data, self::RESULTS_MAP));
    }
}
