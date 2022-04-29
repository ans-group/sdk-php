<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $ipAddress
 * @property string $networkId
 * @property string $type
 * @property string $createdAt
 * @property string $updatedAt
 */
class IpAddress extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'ip_address' => 'ipAddress',
        'network_id' => 'networkId',
        'type' => 'type',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
