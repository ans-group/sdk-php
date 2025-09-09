<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\HostGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class HostGroupClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<HostGroup> */
    use PageItems;

    protected $collectionPath = 'v2/host-groups';

    public function getEntityMap()
    {
        return HostGroup::$entityMap;
    }

    public function loadEntity($data)
    {
        return new HostGroup(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
