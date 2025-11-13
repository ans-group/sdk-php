<?php

namespace Tests\Account;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Account\Entities\Contact;

class ContactTest extends TestCase
{
    /**
     * @test
     */
    public function retrieves_full_name()
    {
        $contact = new Contact;
        $contact->firstName = 'John';
        $contact->lastName = 'Doe';

        $this->assertEquals('John Doe', $contact->fullName());
    }
}
