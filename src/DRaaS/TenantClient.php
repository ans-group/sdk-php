<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\Tenant;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\DRaaS\Entities\RecoveryPlan;

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

    /**
     * @return array<int, RecoveryPlan>
     */
    public function recoveryPlans($tenantId)
    {
        return $this->getChildResources($tenantId, 'recovery-plans', function ($data) {
            return new RecoveryPlan($this->apiToFriendly($data, RecoveryPlan::$entityMap));
        });
    }
}
