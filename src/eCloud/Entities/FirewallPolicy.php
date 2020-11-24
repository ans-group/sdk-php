<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $routerId
 * @property int $sequence
 * @property string $createdAt
 * @property string $updatedAt
 */
class FirewallPolicy extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
