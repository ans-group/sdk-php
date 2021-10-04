<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancerSpec;

class LoadBalancerSpecClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/load-balancer-specs';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
        ];
    }

    public function loadEntity($data)
    {
        return new LoadBalancerSpec(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
