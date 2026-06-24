<?php

namespace UKFast\SDK\DRaaS;

use GuzzleHttp\Exception\GuzzleException;

class RecoveryPlanClient extends Client
{
    /**
     * Start a recovery plan
     * @param string $recoveryPlanId
     * @param string $startDate
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
            )->getStatusCode() === 202;
    }

    /**
     * Stop a recovery plan
     * @param string $recoveryPlanId
     * @return bool
     * @throws GuzzleException
     * @deprecated Use cancel() instead
     */
    public function stop($recoveryPlanId)
    {
        return $this->cancel($recoveryPlanId);
    }

    /**
     * Cancel a recovery plan
     * @param string $recoveryPlanId
     * @return bool
     * @throws GuzzleException
     */
    public function cancel($recoveryPlanId)
    {
        return $this->post(
                'v2/recovery-plans/' . $recoveryPlanId . '/cancel',
                json_encode([]),
                ['Content-Type' => 'application/json']
            )->getStatusCode() === 202;
    }
}