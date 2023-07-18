<?php

namespace UKFast\SDK\Account\Entities;

use UKFast\SDK\Entity;

/**
 * @property-read string $name
 * @property-read string $type
 */
class AvailableRegistrantType extends Entity
{
    public static $entityMap = [
        'name' => 'name',
        'type' => 'type',
    ];
}
