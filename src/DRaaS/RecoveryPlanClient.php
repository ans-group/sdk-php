<?php

namespace UKFast\SDK\DRaaS;

use GuzzleHttp\Exception\GuzzleException;

class RecoveryPlanClient extends Client
{
    /**
     * Start a recovery plan
     * @param $recoveryPlanId
     * @param $startDate
     * @return bool
     * @throws GuzzleException
     */
    public function start($recoveryPlanId, $startDate = null)
    {
        $data = empty($startDate) ? [] : [
            'start_date' => $startDate
        ];

        return $this->post(
                'v2/recovery-plans/' . $recoveryPlanId . '/start',
                json_encode($data),
                ['Content-Type' => 'application/json']
            )->getStatusCode() == 202;
    }

    /**
     * Stop a recovery plan
     * @param $recoveryPlanId
     * @return bool
     * @throws GuzzleException
     */
    public function stop($recoveryPlanId)
    {
        return $this->post(
                'v2/recovery-plans/' . $recoveryPlanId . '/stop',
                json_encode([]),
                ['Content-Type' => 'application/json']
            )->getStatusCode() == 202;
    }
}
