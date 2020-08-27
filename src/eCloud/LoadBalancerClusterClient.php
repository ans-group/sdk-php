<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancerCluster;

class LoadBalancerClusterClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/lbcs';

    public function loadEntity($data)
    {
        return new LoadBalancerCluster(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'availabilityZoneId' => 'availability_zone_id',
            'vpcId' => 'vpc_id',
            'nodes' => 'nodes',
        ];
    }
}
