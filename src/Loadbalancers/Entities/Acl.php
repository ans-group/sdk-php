<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $name
 * @property int $priority
 * @property int $listenerId
 * @property int $targetGroupId
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Acl extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
