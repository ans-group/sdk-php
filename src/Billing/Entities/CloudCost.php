<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $serverId
 * @property Resource $resource
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
