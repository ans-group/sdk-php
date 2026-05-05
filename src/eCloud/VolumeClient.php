<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Volume;

class VolumeClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/volumes';

    public function getEntityMap()
    {
        return Volume::$entityMap;
    }

    public function loadEntity($data)
    {
        return new Volume(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getInstances($id)
    {
        return $this->instances()->getByVolumeId($id);
    }
}
