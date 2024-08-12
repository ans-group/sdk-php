<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $maxUsers
 * @property string $createdAt
 * @property string $updatedAt
 */
class VpnGatewaySpecification extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'created_at' => 'createdAt',
        'name' => 'name',
        'description' => 'description',
        'max_users' => 'maxUsers',
        'updated_at' => 'updatedAt',
    ];
}
