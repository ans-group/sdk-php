<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Entity;

class EntityTest extends TestCase
{
    /**
     * @test
     */
    public function sets_attributes_from_an_array()
    {
        $contact = new Contact([
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe'
        ]);

        $this->assertEquals(1, $contact->id);
        $this->assertEquals('John', $contact->firstName);
        $this->assertEquals('Doe', $contact->lastName);
    }

    /**
     * @test
     */
    public function can_determine_if_an_attribute_is_set()
    {
        $contact = new Contact(['id' => 1]);

        $this->assertTrue($contact->has('id'));
        $this->assertFalse($contact->has('some-other-property'));
    }

    /**
     * @test
     */
    public function can_mass_assign_additional_properties()
    {
        $contact = new Contact(['id' => 1]);

        $this->assertFalse($contact->has('firstName'));

        $contact->fill(['firstName' => 'John']);

        $this->assertEquals('John', $contact->firstName);
    }

    /**
     * @test
     */
    public function can_map_properties_with_to_array()
    {
        $contact = new Contact([
            'id' => 1,
            'firstName' => 'John',
            'createdDate' => '2010-01-01',
        ]);

        $this->assertEquals([
            'id' => 1,
            'first_name' => 'John',
            'created_date' => '2010-01-01',
        ], $contact->toArray([
            'firstName' => 'first_name',
            'createdDate' => 'created_date'
        ]));
    }

    /**
     * @test
     */
    public function to_array_still_returns_properties_that_arent_present_in_map()
    {
        $contact = new Contact([
            'id' => 1,
            'firstName' => 'John',
        ]);

        $this->assertEquals([
            'id' => 1,
            'firstName' => 'John'
        ], $contact->toArray());
    }
}


/**
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property string $createdDate
 */
class Contact extends Entity
{
    protected $readOnly = ['createdDate'];
}