<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VolumeGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VolumeGroupClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<VolumeGroup> */
    use PageItems;

    protected $collectionPath = 'v2/volume-groups';

    public function getEntityMap()
    {
        return VolumeGroup::$entityMap;
    }

    public function loadEntity($data)
    {
        return new VolumeGroup(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
