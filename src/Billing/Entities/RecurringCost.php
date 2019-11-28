<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;
use DateTime;
use UKFast\SDK\PSS\Entities\Product;

/**
 * @property int $id
 * @property string $name
 * @property Product $product
 * @property float $total
 * @property string $period
 * @property int $interval
 * @property string $paymentMethod
 * @property DateTime $nextPaymentAt
 * @property DateTime $createdAt
 */
class RecurringCost extends Entity
{
    protected $dates = ['nextPaymentAt', 'createdAt'];
}
