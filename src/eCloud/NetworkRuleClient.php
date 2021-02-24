<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\NetworkRule;

class NetworkRuleClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/network-rules';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'network_policy_id' => 'policyId',
            'source' => 'source',
            'destination' => 'destination',
            'action' => 'action',
            'sequence' => 'sequence',
            'enabled' => 'enabled',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new NetworkRule(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
