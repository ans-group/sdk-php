<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $availabilityZoneId
 * @property integer $committedBandwidth
 * @property string $createdAt
 * @property string $updatedAt
 */
class RouterThroughput extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
