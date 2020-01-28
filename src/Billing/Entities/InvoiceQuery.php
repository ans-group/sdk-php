<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $contactId
 * @property float $amount
 * @property string $whatWasExpected
 * @property string $whatWasReceived
 * @property string $proposedSolution
 * @property string $contactMethod
 * @property array $invoiceIds
 * @property string $resolution
 * @property \DateTime $resolutionDate
 * @property string $status
 * @property \DateTime $date
 */
class InvoiceQuery extends Entity
{
    protected $dates = [
        'resolutionDate',
        'date'
    ];
}
