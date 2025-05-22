<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $routerId
 * @property string $specificationId
 * @property object $sync
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class MonitoringGateway extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'router_id' => 'routerId',
        'specification_id' => 'specificationId',
        'sync' => 'sync',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',

    ];
}
