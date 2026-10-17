<?php

namespace Tests\Domains;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\Entities\DomainAvailability;
use UKFast\SDK\Domains\Entities\DomainRenewal;
use UKFast\SDK\Domains\Money;

class DomainPricingTest extends TestCase
{
    public function testAvailabilityReadsTheTierAndPerTermPrices()
    {
        $availability = new DomainAvailability((object) [
            'domain' => 'dadflix.online',
            'available' => true,
            'tier' => 'standard',
            'terms' => [
                (object) [
                    'period' => 1,
                    'registration_price' => '22.67',
                    'privacy_price' => '3.30',
                    'renewal_price' => '22.67',
                ],
                (object) [
                    'period' => 10,
                    'registration_price' => '226.70',
                    'privacy_price' => '0.00',
                    'renewal_price' => null,
                ],
            ],
        ]);

        $this->assertSame('standard', $availability->tier);
        $this->assertFalse($availability->isPremium());
        $this->assertFalse($availability->premium);
        $this->assertSame('22.67', $availability->terms[0]->registration_price);
        $this->assertSame('22.67', $availability->terms[0]->renewal_price);
        $this->assertSame('226.70', $availability->terms[1]->registration_price);
        $this->assertNull($availability->terms[1]->renewal_price);
    }

    public function testAvailabilityKeepsPriceReadableAsTheRegistrationPrice()
    {
        $availability = new DomainAvailability([
            'tier' => 'standard',
            'terms' => [['period' => 1, 'registration_price' => '22.67']],
        ]);

        $this->assertSame('22.67', $availability->terms[0]->price);
    }

    public function testAvailabilityDetectsAPremiumName()
    {
        $availability = new DomainAvailability(['available' => true, 'tier' => 'premium', 'terms' => []]);

        $this->assertTrue($availability->isPremium());
        $this->assertTrue($availability->premium);
    }

    public function testAvailabilityStillReadsTheOlderResponseShape()
    {
        $availability = new DomainAvailability([
            'available' => true,
            'premium' => true,
            'terms' => [['period' => 1, 'price' => '277.30', 'privacy_price' => '3.30']],
        ]);

        $this->assertSame('premium', $availability->tier);
        $this->assertTrue($availability->isPremium());
        $this->assertSame('277.30', $availability->terms[0]->registration_price);
        $this->assertNull($availability->terms[0]->renewal_price);
    }

    public function testThePriceToConfirmWhenRegisteringAddsPrivacyOnlyWhenRequested()
    {
        $term = (new DomainAvailability([
            'tier' => 'standard',
            'terms' => [['period' => 2, 'registration_price' => '29.20', 'privacy_price' => '6.50']],
        ]))->terms[0];

        $this->assertSame('29.20', $term->priceToConfirm());
        $this->assertSame('35.70', $term->priceToConfirm(true));
    }

    public function testThePriceToConfirmWithPrivacyIsNullWhenPrivacyCannotBePriced()
    {
        $term = (new DomainAvailability([
            'tier' => 'standard',
            'terms' => [['period' => 1, 'registration_price' => '29.20', 'privacy_price' => null]],
        ]))->terms[0];

        $this->assertSame('29.20', $term->priceToConfirm());
        $this->assertNull($term->priceToConfirm(true));
    }

    public function testRenewalPriceIsTheTotalToConfirmWhenTheDomainHasPrivacy()
    {
        $renewal = new DomainRenewal([
            'available' => true,
            'terms' => [
                ['period' => 1, 'renewal_price' => '15.99', 'privacy_price' => '3.30'],
                ['period' => 2, 'renewal_price' => '31.20', 'privacy_price' => '6.50'],
            ],
        ]);

        $this->assertSame('15.99', $renewal->terms[0]->renewal_price);
        $this->assertSame('3.30', $renewal->terms[0]->privacy_price);
        $this->assertSame('19.29', $renewal->terms[0]->price);
        $this->assertSame('37.70', $renewal->terms[1]->price);
    }

    public function testRenewalPriceIsTheRenewalPriceWhenTheDomainHasNoPrivacy()
    {
        $renewal = new DomainRenewal([
            'available' => true,
            'terms' => [['period' => 1, 'renewal_price' => '15.99', 'privacy_price' => null]],
        ]);

        $this->assertSame('15.99', $renewal->terms[0]->price);
        $this->assertNull($renewal->terms[0]->privacy_price);
    }

    public function testRenewalStillReadsTheOlderResponseShape()
    {
        $renewal = new DomainRenewal([
            'available' => true,
            'terms' => [
                ['period' => 1, 'price' => '19.29', 'privacy_price' => '3.30'],
                ['period' => 2, 'price' => '36.75', 'privacy_price' => null],
            ],
        ]);

        // The older "price" already included privacy, so it is still the amount to confirm.
        $this->assertSame('19.29', $renewal->terms[0]->price);
        $this->assertSame('15.99', $renewal->terms[0]->renewal_price);
        $this->assertSame('36.75', $renewal->terms[1]->price);
        $this->assertSame('36.75', $renewal->terms[1]->renewal_price);
    }

    public function testMoneyAddsAndSubtractsExactly()
    {
        $this->assertSame('0.30', Money::add('0.10', '0.20'));
        $this->assertSame('9.99', Money::subtract('13.29', '3.30'));
        $this->assertSame('1385.70', Money::add('1382.40', '3.30'));
    }
}
