<?php

namespace UKFast\SDK\DRaaS\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property object{id: string, name: string} $pod
 * @property object{status: string} $sync
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class Tenant extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'pod' => 'pod',
        'sync' => 'sync',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
