<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\HostGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class HostGroupClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/host-groups';

    public function loadEntity($data)
    {
        return new HostGroup(
            $this->apiToFriendly($data, HostGroup::$entityMap)
        );
    }
}
