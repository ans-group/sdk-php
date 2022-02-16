<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancerNetwork;

class LoadBalancerNetworkClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/load-balancer-networks';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'load_balancer_id' => 'loadBalancerId',
            'network_id' => 'networkId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new LoadBalancerNetwork(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getAllByLoadBalancerId($id)
    {
        return $this->getAll([
            'load_balancer_id' => $id
        ]);
    }
}
