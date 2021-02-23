<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $frontendId
 * @property string $vipsId
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
}
