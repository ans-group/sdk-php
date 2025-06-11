<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\FirewallRule;

class FirewallRuleClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<FirewallRule> */
    use PageItems;

    protected $collectionPath = 'v2/firewall-rules';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'firewall_policy_id' => 'policyId',
            'source' => 'source',
            'destination' => 'destination',
            'action' => 'action',
            'direction' => 'direction',
            'sequence' => 'sequence',
            'enabled' => 'enabled',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new FirewallRule(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
