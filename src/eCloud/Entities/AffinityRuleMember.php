<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $instanceId
 * @property string $affinityRuleId
 * @property string $createdAt
 */
class AffinityRuleMember extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'instance_id' => 'instanceId',
        'affinity_rule_id' => 'affinityRuleId',
        'created_at' => 'createdAt',
    ];
}
