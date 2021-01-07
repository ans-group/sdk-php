<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property float $commitment
 * @property string $rate
 * @property string $term
 * @property string $start
 * @property string $end
 * @property string $createdAt
 * @property string $updatedAt
 */
class DiscountPlan extends Entity
{
    protected $dates = [
        'start',
        'end',
        'createdAt',
        'updatedAt'
    ];
}
