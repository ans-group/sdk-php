<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $ip
 * @property string $createdAt
 * @property string $updatedAt
 */
class AccessIp extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
