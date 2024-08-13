<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $availabilityZoneId
 * @property string $routerId
 * @property string $networkId
 * @property string $specificationId
 * @property string $instanceId
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class VpnGateway extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'availability_zone_id' => 'availabilityZoneId',
        'router_id' => 'routerId',
        'network_id' => 'networkId',
        'specification_id' => 'specificationId',
        'instance_id' => 'instanceId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
