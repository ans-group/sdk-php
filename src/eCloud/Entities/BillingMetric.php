<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $vpcName
 * @property string $resourceId
 * @property string $resourceName
 * @property string $key
 * @property string $value
 * @property string $start
 * @property string $end
 * @property string $category
 * @property float $price
 * @property string $createdAt
 * @property string $updatedAt
 */
class BillingMetric extends Entity
{
    protected $dates = [
        'start',
        'end',
        'createdAt',
        'updatedAt'
    ];
}
