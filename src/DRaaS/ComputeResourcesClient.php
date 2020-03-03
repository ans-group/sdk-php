<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\ComputeResources;
use UKFast\SDK\Entities\ClientEntityInterface;

class ComputeResourcesClient extends Client implements ClientEntityInterface
{
    const MAP = [];

    public function loadEntity($data)
    {
        return new ComputeResources($this->apiToFriendly($data, static::MAP));
    }
}
