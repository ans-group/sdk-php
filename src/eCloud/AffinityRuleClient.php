<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\AffinityRule;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class AffinityRuleClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/affinity-rules';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'type' => 'type',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new AffinityRule(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
