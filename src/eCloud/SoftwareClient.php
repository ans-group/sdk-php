<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Software;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class SoftwareClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/software';

    public function loadEntity($data)
    {
        return new Software(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return Software::$entityMap;
    }
}
