<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Billing\Entities\RecurringCosts\Partner;
use UKFast\SDK\Billing\Entities\RecurringCosts\Product;
use UKFast\SDK\Billing\Entities\RecurringCosts\Type;
use UKFast\SDK\Entity;
use DateTime;

/**
 * @property int $id
 * @property Type $type
 * @property string $description
 * @property string $status
 * @property mixed $orderId
 * @property string $purchaseOrderId
 * @property int $costCentreId
 * @property Product $product
 * @property float $cost
 * @property string $period
 * @property int $interval
 * @property boolean $byCard
 * @property DateTime $nextPaymentAt
 * @property DateTime $endDate
 * @property DateTime $contractEndDate
 * @property DateTime $frozenEndDate
 * @property DateTime $migrationEndDate
 * @property DateTime $createdAt
 * @property Partner $partner
 * @property int $projectId
 */
class RecurringCost extends Entity
{
    protected $dates = [
        'nextPaymentAt',
        'endDate',
        'contractEndDate',
        'frozenEndDate',
        'migrationEndDate',
        'createdAt'
    ];

    /**
     * Returns interval & period as a friendly frequency
     *
     * @return string
     */
    public function frequency()
    {
        if ($this->period == 'Monthly' && $this->interval == 1) {
            return 'Monthly';
        }

        if ($this->period == 'Monthly' && $this->interval == 3) {
            return 'Quarterly';
        }

        if ($this->period == 'Yearly' && $this->interval == 1) {
            return 'Yearly';
        }

        if ($this->period == 'Monthly') {
            return 'Every ' . $this->interval . ' Months';
        }

        return 'Every ' . $this->interval . ' Years';
    }
}
