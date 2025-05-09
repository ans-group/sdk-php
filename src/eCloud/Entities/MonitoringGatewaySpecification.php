<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property int $order
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class MonitoringGatewaySpecification extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'order' => 'order',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',

    ];
}
