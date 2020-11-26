<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $ruleId
 * @property string $protocol
 * @property string $source
 * @property string $destination
 * @property string $createdAt
 * @property string $updatedAt
 */
class FirewallRulePort extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
