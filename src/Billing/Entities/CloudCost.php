<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $serverId
 * @property \DateTime $billing_start
 * @property \DateTime $billing_end
 * @property Resource $resource
 * @property string $period
 * @property float $price
 * @property \DateTime $billingDueDate
 */
class CloudCost extends Entity
{
    protected $dates = ['startAt', 'endAt', 'nextPaymentOn', 'lastPaymentAt'];

    /**
     * @return bool
     */
    public function isBillingCompleted()
    {
        return $this->resource->billing_end != '0000-00-00 00:00:00';
    }
}
