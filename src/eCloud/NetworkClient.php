<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Network;

class NetworkClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/networks';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'router_id' => 'routerId',
            'subnet' => 'subnet',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Network(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
