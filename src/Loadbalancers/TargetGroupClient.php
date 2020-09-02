<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\TargetGroup;
use UKFast\SDK\Traits\PageItems;

class TargetGroupClient extends Client implements ClientEntityInterface
{
    protected $collectionPath = 'v2/groups';

    use PageItems;

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name'
        ];
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\TargetGroup
     */
    public function loadEntity($data)
    {
        return new TargetGroup($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
