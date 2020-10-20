<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $createdAt
 * @property string $updatedAt
 */
class Cluster extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
