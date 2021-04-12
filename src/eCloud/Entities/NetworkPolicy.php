<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $networkId
 * @property int $sync
 * @property string $createdAt
 * @property string $updatedAt
 */
class NetworkPolicy extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
