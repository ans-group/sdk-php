<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\ResourceTier;

class ResourceTierClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<ResourceTier> */
    use PageItems;

    protected $collectionPath = 'v2/resource-tiers';

    public function getEntityMap()
    {
        return ResourceTier::$entityMap;
    }

    public function loadEntity($data)
    {
        return new ResourceTier(
            $this->apiToFriendly($data, ResourceTier::$entityMap)
        );
    }
}
