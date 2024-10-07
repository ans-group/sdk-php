<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $fqdn
 * @property string $availabilityZoneId
 * @property string $routerId
 * @property string $specificationId
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class VpnGateway extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'fqdn' => 'fqdn',
        'availability_zone_id' => 'availabilityZoneId',
        'router_id' => 'routerId',
        'specification_id' => 'specificationId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
