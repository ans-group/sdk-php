<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\FloatingIp;

class FloatingIpClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/floating-ips';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'ip_address' => 'ipAddress',
            'resource_id' => 'resourceId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new FloatingIp(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function assignResourceById($id, $resourceId)
    {
        $response = $this->post(
            $this->collectionPath . '/' . $id . '/assign',
            json_encode([
                "resource_id" => $resourceId,
            ])
        );

        return $response->getStatusCode() == 202;
    }

    public function unassignResourceById($id)
    {
        $response = $this->post(
            $this->collectionPath . '/' . $id . '/unassign'
        );

        return $response->getStatusCode() == 202;
    }
}
