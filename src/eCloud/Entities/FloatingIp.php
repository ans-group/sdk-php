<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $ipAddress
 * @property string $rdnsHostname
 * @property string $resourceId
 * @property string $createdAt
 * @property string $updatedAt
 */
class FloatingIp extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'ip_address' => 'ipAddress',
        'rdns_hostname' => 'rdnsHostname',
        'resource_id' => 'resourceId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
