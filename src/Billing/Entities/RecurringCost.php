<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;
use DateTime;
use UKFast\SDK\Billing\Entities\Product;

/**
 * @property int $id
 * @property int $referenceId
 * @property string $referenceName
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

    /**
     * Returns interval & period as a friendly frequency
     * @return string
     */
    public function frequency()
    {
        if ($this->period == 'monthly' && $this->interval == 1) {
            return 'Monthly';
        }

        if ($this->period == 'monthly' && $this->interval == 3) {
            return 'Quarterly';
        }

        if ($this->period == 'yearly' && $this->interval == 1) {
            return 'Yearly';
        }

        if ($this->period == 'monthly') {
            return 'Every ' . $this->interval . ' Months';
        }

        return 'Every ' . $this->interval . ' Years';
    }
}
