<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property bool $deployed
 * @property \DateTime $deployedAt
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Cluster extends Entity
{
    protected $dates = ['deployedAt', 'createdAt', 'updatedAt'];
}
