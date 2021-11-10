<?php

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\Page;
use UKFast\SDK\ThreatMonitoring\Entities\Alert;

class AlertClient extends Client
{
    const ALERT_MAP = [
        'agent_id' => 'agentId',
        'agent_name' => 'agentName',
        'pci_dss' => 'pciDss',
        'full_log' => 'fullLog'
    ];

    const SYSCHECK_MAP = [
        'effective_user_name' => 'effectiveUserName',
        'process_name' => 'processName',
        'process_id' => 'processId',
        'changed_attributes' => 'changedAttributes'
    ];

    const ANALYSIS_MAP = [
        'total_reports' => 'totalReports',
        'last_reported' => 'lastReported'
    ];

    /**
     * Gets paginated response for all the alerts
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/alerts', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeAlertResponse($item);
        });

        return $page;
    }

    /**
     * Get an alert by its ID
     * @param $id
     * @return Alert
     */
    public function getById($id)
    {
        $response = $this->get('v1/alerts/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeAlertResponse($body->data);
    }

    /**
     * Get all alerts
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAlerts($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/alerts/rules', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeAlertResponse($item);
        });

        return $page;
    }

    /**
     * Encode and send the data to the API.
     *
     * @param $data
     */
    public function toggleAlerts($data)
    {
        $response = $this->post('v1/alerts/rules/toggle', json_encode($data));
        $body = $this->decodeJson($response->getBody()->getContents());
        return $body;
    }

    /**
     * Encode and send the data to the API.
     *
     * @param $data
     */
    public function bulkToggleAlerts($data)
    {
        $response = $this->post('v1/alerts/rules/bulk-toggle', json_encode($data));
        $body = $this->decodeJson($response->getBody()->getContents());
        return $body;
    }

    /**
     * Serialize the response to use friendly names
     * @param $data
     * @return Alert
     */
    public function serializeAlertResponse($data)
    {
        $alert = new Alert($this->apiToFriendly($data, static::ALERT_MAP));

        if (isset($alert->syscheck)) {
            $alert->set('syscheck', $this->apiToFriendly($alert->syscheck, static::SYSCHECK_MAP));
        }

        if (isset($alert->analysis)) {
            $alert->set('analysis', $this->apiToFriendly($alert->analysis, static::ANALYSIS_MAP));
        }

        return $alert;
    }
}
