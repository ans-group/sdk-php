<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $listenerId
 * @property string $vipId
 * @property int $port
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Bind extends Entity
{
    protected $dates = [
        'createdAt',
        'updatedAt'
    ];

    public static $entityMap = [
        'listener_id' => 'listenerId',
        'vip_id' => 'vipId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
