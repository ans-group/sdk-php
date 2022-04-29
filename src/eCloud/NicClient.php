<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\eCloud\Entities\Nic;
use UKFast\SDK\Traits\PageItems;

class NicClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/nics';

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

    public function assignIpAddress($id, $ipAddressId)
    {
        $response = $this->post(
            $this->collectionPath . '/' . $id . '/ip-addresses',
            json_encode(['ip_address_id' => $ipAddressId])
        );
        return $response->getStatusCode() == 202;
    }
}
