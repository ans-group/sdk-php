<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Domains\Money;
use UKFast\SDK\Entity;

/**
 * One renewal term for a registered domain. All prices are decimal strings in GBP, excluding VAT.
 *
 * @property int $period The renewal term in years
 * @property string $renewal_price The domain's renewal for the term, without privacy
 * @property string|null $privacy_price The privacy renewal for the term, or null when the domain has no privacy
 * @property string $price The price to send to DomainRegistrationClient::renew(): renewal_price plus privacy_price
 *                         when the domain has privacy
 */
class DomainRenewalTerm extends Entity
{
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        $attributes = $this->withBothPrices($attributes);

        parent::__construct($attributes);
    }

    /**
     * The API now returns renewal_price (the domain only) and privacy_price, and the caller confirms their sum. It used
     * to return that sum as "price". Either shape is accepted, and "price" is always the amount to confirm.
     *
     * @param array $attributes
     * @return array
     */
    private function withBothPrices(array $attributes)
    {
        $privacyPrice = isset($attributes['privacy_price']) ? $attributes['privacy_price'] : null;

        if (array_key_exists('renewal_price', $attributes)) {
            $attributes['price'] = $privacyPrice === null
                ? $attributes['renewal_price']
                : Money::add($attributes['renewal_price'], $privacyPrice);

            return $attributes;
        }

        if (array_key_exists('price', $attributes)) {
            $attributes['renewal_price'] = $privacyPrice === null
                ? $attributes['price']
                : Money::subtract($attributes['price'], $privacyPrice);
        }

        return $attributes;
    }
}
