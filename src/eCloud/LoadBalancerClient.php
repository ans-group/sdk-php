<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancer;

class LoadBalancerClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/load-balancers';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'load_balancer_spec_id' => 'specId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new LoadBalancer(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
