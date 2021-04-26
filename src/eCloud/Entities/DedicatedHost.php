<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $groupId
 * @property string $sync
 * @property string $createdAt
 * @property string $updatedAt
 */
class DedicatedHost extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
