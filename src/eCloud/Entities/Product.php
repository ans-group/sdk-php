<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $availability_zone_id
 * @property string $name
 * @property string $category
 * @property string $price
 * @property string $rate
 */
class Product extends Entity
{
    public static $entityMap = [
        'availability_zone_id' => 'availabilityZoneId',
        'name' => 'name',
        'category' => 'category',
        'price' => 'price',
        'rate' => 'rate',
    ];
}
