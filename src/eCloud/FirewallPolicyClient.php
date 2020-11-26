<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\FirewallPolicy;

class FirewallPolicyClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/firewall-policies';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'router_id' => 'routerId',
            'sequence' => 'sequence',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new FirewallPolicy(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
