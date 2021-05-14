<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\NetworkPolicy;

class NetworkPolicyClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/network-policies';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'network_id' => 'networkId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new NetworkPolicy(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
