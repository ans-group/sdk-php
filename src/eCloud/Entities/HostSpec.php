<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $cpuType
 * @property integer $cpuSockets
 * @property integer $cpuCores
 * @property integer $cpuSpeed
 * @property integer $ramCapacity
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $availableHostQuantity
 */
class HostSpec extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
