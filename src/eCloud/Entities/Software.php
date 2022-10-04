<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $platform
 * @property string $license
 */
class Software extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'platform' => 'platform',
        'license' => 'license',
    ];
}
