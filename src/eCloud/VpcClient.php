<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Vpc;

class VpcClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<Vpc> */
    use PageItems;

    protected $collectionPath = 'v2/vpcs';

    public function loadEntity($data)
    {
        return new Vpc(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @return array<string, string>
     */
    public function getEntityMap()
    {
        return Vpc::$entityMap;
    }
}
