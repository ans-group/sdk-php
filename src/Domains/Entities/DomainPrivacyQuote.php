<?php

namespace UKFast\SDK\Domains\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * Whether WHOIS privacy can be enabled on a domain now, and what it costs for the rest of the registration term.
 * The price is a decimal string in GBP, excluding VAT.
 *
 * @property bool $available Whether privacy can be enabled now
 * @property string|null $price The price to send to DomainClient::updateWhoisPrivacy() when enabling privacy.
 *                              "0.00" when free or already paid for, null when privacy is already enabled or
 *                              cannot be priced
 * @property int $period The number of years the price covers
 * @property DateTime|null $paidUntil The end of an earlier paid privacy period that is still running
 */
class DomainPrivacyQuote extends Entity
{
    /**
     * Dates to map to \DateTime objects
     *
     * @var array $dates
     */
    protected $dates = [
        'paidUntil',
    ];

    /**
     * Sets an attribute. A null date stays null rather than being parsed.
     *
     * @param string $attr
     * @param mixed $value
     * @return void
     */
    public function set($attr, $value)
    {
        if (is_null($value)) {
            $this->attributes[$attr] = null;
            return;
        }

        parent::set($attr, $value);
    }
}
