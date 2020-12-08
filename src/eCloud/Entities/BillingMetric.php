<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $resourceId
 * @property string $key
 * @property string $value
 * @property string $start
 * @property string $end
 * @property string $createdAt
 * @property string $updatedAt
 */
class BillingMetric extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
