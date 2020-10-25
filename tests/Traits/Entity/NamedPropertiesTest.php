<?php

namespace Tests\Traits\Entity;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Entity;
use UKFast\SDK\Traits\Entity\NamedProperties;

class NamedPropertiesTest extends TestCase
{
    /**
     * @test
     */
    public function entity_only_has_defined_properties()
    {
        $entityData = [
            'id' => 'id',
            'name' => 'name',
            'foo' => 'bar',
        ];

        $entity = new NamedPropertiesEntity($entityData);
        $this->assertFalse(isset($entity->foo));

        $entity = new NamedPropertiesEntity((object) $entityData);
        $this->assertFalse(isset($entity->foo));
    }
}

/**
 * @property int $id
 * @property string $name
 */
class NamedPropertiesEntity extends Entity
{
    use NamedProperties;
}
