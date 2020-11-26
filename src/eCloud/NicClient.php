<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\eCloud\Entities\Nic;

class NicClient extends Client implements ClientEntityInterface
{
    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'ip_address' => 'ipAddress',
            'mac_address' => 'macAddress',
            'instance_id' => 'instanceId',
            'network_id' => 'networkId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Nic(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
