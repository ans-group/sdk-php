<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $listenerId
 * @property string $targetgroupId
 * @property string $createdAt
 * @property string $updatedAt
 */
class Acl extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
