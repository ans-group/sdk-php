<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\Tenant;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class TenantClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/tenants';

    /**
     * @param array<string, mixed> $data
     * @return Tenant
     */
    public function loadEntity($data)
    {
        return new Tenant(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @return array<string, string>
     */
    public function getEntityMap()
    {
        return Tenant::$entityMap;
    }
}
