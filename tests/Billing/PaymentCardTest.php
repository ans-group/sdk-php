<?php

namespace Tests\Billing;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Billing\Entities\PaymentCard;

class PaymentCardTest extends TestCase
{
    protected $data = [
        'name' => 'Test User',
        'address' => 'Test St.',
        'postcode' => 'M44 0AB',
        'cardNumber' => '1234 1234 1234 1234',
        'cardType' => 'VISA',
        'validFrom' => null,
        'issueNumber' => null,
        'primaryCard' => false
    ];

    /**
     * @test
     */
    public function is_expired_check_rejects_expired_card()
    {
        $card = new PaymentCard($this->data);
        $card->expiry = '12/18';

        $this->assertTrue($card->isExpired());
        $this->assertFalse($card->isNotExpired());
    }

    /**
     * @test
     */
    public function is_expired_check_allows_valid_card()
    {
        $year = date('y') + 5;

        $card = new PaymentCard($this->data);
        $card->expiry = '12/'.$year;

        $this->assertFalse($card->isExpired());
        $this->assertTrue($card->isNotExpired());
    }

    /**
     * @test
     */
    public function is_expired_check_accepts_current_month()
    {
        $month = date('m');
        $year = date('y') + 5;

        $card = new PaymentCard($this->data);
        $card->expiry = $month.'/'.$year;

        $this->assertFalse($card->isExpired());
        $this->assertTrue($card->isNotExpired());
    }
}