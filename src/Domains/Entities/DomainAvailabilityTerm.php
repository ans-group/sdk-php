<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Domains\Money;
use UKFast\SDK\Entity;

/**
 * One registration term from a domain availability check. All prices are decimal strings in GBP, excluding VAT.
 *
 * @property int $period The registration term in years
 * @property string $registration_price The total to register for the term, without privacy
 * @property string|null $privacy_price What adding privacy costs for the term ("0.00" when free, null when it
 *                                      cannot be priced)
 * @property string|null $renewal_price What renewing for the same number of years as the term costs, without
 *                                      privacy. Null when no renewal price is available for that length.
 * @property string $price Deprecated alias of registration_price
 */
class DomainAvailabilityTerm extends Entity
{
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        // The API used to call registration_price "price". Accept either, and keep both readable.
        if (array_key_exists('registration_price', $attributes) && !array_key_exists('price', $attributes)) {
            $attributes['price'] = $attributes['registration_price'];
        } elseif (array_key_exists('price', $attributes) && !array_key_exists('registration_price', $attributes)) {
            $attributes['registration_price'] = $attributes['price'];
        }

        parent::__construct($attributes);
    }

    /**
     * The price to confirm when registering the domain for this term (the registration price, plus the privacy price
     * when privacy is requested). Null when privacy is requested but cannot be priced.
     *
     * @param bool $withPrivacy
     * @return string|null
     */
    public function priceToConfirm($withPrivacy = false)
    {
        if (!$withPrivacy) {
            return $this->registration_price;
        }

        if ($this->privacy_price === null) {
            return null;
        }

        return Money::add($this->registration_price, $this->privacy_price);
    }
}
