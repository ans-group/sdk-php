<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $maxUsers
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class VpnGatewaySpecification extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'max_users' => 'maxUsers',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
