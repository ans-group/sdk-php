<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property DateTime $billingPeriodStart
 * @property DateTime $billingPeriodEnd
 * @property float $consumptionTotal
 * @property float $planSpendLimit
 * @property float $planOverage
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class BillingHistory extends Entity
{
    protected $dates = ['billingPeriodStart', 'billingPeriodEnd', 'createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'billing_period_start' => 'billingPeriodStart',
        'billing_period_end' => 'billingPeriodEnd',
        'consumption_total' => 'consumptionTotal',
        'plan_spend_limit' => 'planSpendLimit',
        'plan_overage' => 'planOverage',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
