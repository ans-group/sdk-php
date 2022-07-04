<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $datacentreSiteId
 * @property string $resourceTierId
 * @property string $createdAt
 * @property string $updatedAt
 */
class AvailabilityZone extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'code' => 'code',
        'datacentre_site_id' => 'datacentreSiteId',
        'resource_tier_id' => 'resourceTierId',
    ];
}
