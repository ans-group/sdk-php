<?php

namespace UKFast\SDK\ThreatMonitoring\Reporting;

use UKFast\SDK\ThreatMonitoring\Client;
use UKFast\SDK\ThreatMonitoring\Entities\ScaResults;
use UKFast\SDK\ThreatMonitoring\Entities\ScaScoreAverage;
use UKFast\SDK\ThreatMonitoring\Entities\ScaSuggestionResults;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsList;
use UKFast\SDK\ThreatMonitoring\Entities\TopAlertsType;

class ScaClient extends Client
{
    const SUGGESTION_MAP = [];

    const INDIVIDUAL_MAP = [];

    const SCA_SCORE_AVERAGE_MAP = [];

    /**
     * Get Sca Data
     *
     * @param $agentId
     * @return false|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSca($agentId)
    {
        $response = $this->get('v1/agents/' . $agentId . '/sca');
        $data = $this->decodeJson($response->getBody()->getContents())->data;
        return new ScaResults($this->apiToFriendly($data, self::INDIVIDUAL_MAP));
    }

    /**
     * Get individual Sca suggestions for a given agent and policy combo.
     *
     * @param $agentId
     * @param $policyId
     * @return false|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getScaBreakdown($agentId, $policyId)
    {
        $response = $this->get('v1/agents/' . $agentId . '/sca/checks/' . $policyId);
        $data = $this->decodeJson($response->getBody()->getContents());
        return new ScaSuggestionResults($this->apiToFriendly($data, self::INDIVIDUAL_MAP));
    }

    /**
     * Get average sca scores for agents for a reseller.
     *
     * @param array $filters
     * @return ScaScoreAverage
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getScaScoreAverage($filters = []) : ScaScoreAverage
    {
        $queryParams = '';

        if (count($filters)) {
            $queryParams = '?' . http_build_query($filters);
        }

        $response = $this->get('v1/reports/sca-score/average' . $queryParams);

        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeScaScoreAverage($body->data);
    }

    public function serializeScaScoreAverage($data)
    {
        return new ScaScoreAverage($this->apiToFriendly($data, static::SCA_SCORE_AVERAGE_MAP));
    }
}
