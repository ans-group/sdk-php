<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\HardwarePlan;
use UKFast\SDK\DRaaS\Entities\Replica;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\SelfResponse;

class ReplicaClient extends Client
{
    const MAP = [];

    public function setIops($solutionId, $replicaId, $iopsTier)
    {
        $data['iops_tier_id'] = $iopsTier;

        $response = $this->post("v1/solutions/" . $solutionId . '/replicas/' . $replicaId . '/iops', json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        return $response->getStatusCode() == 204;
    }
}
