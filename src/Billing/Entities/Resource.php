<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $type
 * @property int $quantity
 * @property int $price
 * @property string $period
 * @property float $usage_since_last_invoice
 * @property float $cost_since_last_invoice
 * @property float $usage_for_period_estimate
 * @property float $cost_for_period_estimate
 * @property \DateTime $billing_start
 * @property \DateTime $billing_end
 * @property \DateTime $billing_due_date
 * @property boolean $billing_item_bill_complete
 */
class Resource extends Entity
{
    //
}
