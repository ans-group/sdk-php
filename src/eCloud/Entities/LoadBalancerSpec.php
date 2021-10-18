<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $createdAt
 * @property string $updatedAt
 */
class LoadBalancerSpec extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
