<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\FirewallRulePort;

class FirewallRulePortClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/firewall-rule-ports';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'firewall_rule_id' => 'ruleId',
            'protocol' => 'protocol',
            'source' => 'source',
            'destination' => 'destination',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new FirewallRulePort(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
