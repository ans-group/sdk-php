<?php

namespace Tests\eCloud;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreEntityHydrateTest extends TestCase
{
    /**
     * @test
     */
    public function hydrates_entity()
    {
        $properties = [
            'id' => 123,
            'nonExistentProperty' => 'test'
        ];

        $datastore = new Datastore($properties);

        // Assert that allowed property was hydrated on the entity
        $this->assertEquals(123, $datastore->id);

        $this->assertObjectNotHasAttribute('nonExistentProperty', $datastore);
    }
}
