<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\NetworkRulePort;

class NetworkRulePortClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<NetworkRulePort> */
    use PageItems;

    protected $collectionPath = 'v2/network-rule-ports';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'network_rule_id' => 'ruleId',
            'protocol' => 'protocol',
            'source' => 'source',
            'destination' => 'destination',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new NetworkRulePort(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
