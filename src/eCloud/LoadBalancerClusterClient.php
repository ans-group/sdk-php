<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancerCluster;

class LoadBalancerClusterClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/lbcs';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'name' => 'name',
            'config_id' => 'configId',
            'nodes' => 'nodes',
        ];
    }

    public function loadEntity($data)
    {
        return new LoadBalancerCluster(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
