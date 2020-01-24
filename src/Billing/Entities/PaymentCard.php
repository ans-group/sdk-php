<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;
use DateTime;

/**
 * @property int $id
 * @property string $friendlyName
 * @property string $name
 * @property string $address
 * @property string $postcode
 * @property string $cardNumber
 * @property string $cardType
 * @property string $validFrom
 * @property string $expiry
 * @property int $issueNumber
 * @property boolean $primaryCard
 */
class PaymentCard extends Entity
{
    /**
     * Check if the PaymentCard has expired.
     *
     * @return bool
     * @throws \Exception
     */
    public function isExpired()
    {
        $date = DateTime::createFromFormat('m/y H:i:s', $this->expiry . ' 23:59:59');
        $input = new DateTime($date->format('Y-m-t H:i:s'));

        return $input < new DateTime();
    }

    /**
     * Check if the PaymentCard has not yet expired.
     *
     * @return bool
     * @throws \Exception
     */
    public function isNotExpired()
    {
        return !$this->isExpired();
    }
}
