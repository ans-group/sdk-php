<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\InstanceSoftware;

class InstanceSoftwareClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<InstanceSoftware> */
    use PageItems;

    protected $collectionPath = 'v2/instance-software';

    public function getEntityMap()
    {
        return InstanceSoftware::$entityMap;
    }

    public function loadEntity($data)
    {
        return new InstanceSoftware(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
