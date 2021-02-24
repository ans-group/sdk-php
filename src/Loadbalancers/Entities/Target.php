<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $targetGroupId
 * @property string $name
 * @property string $ip
 * @property integer $port
 * @property integer $weight
 * @property boolean $backup
 * @property integer $checkInterval
 * @property boolean $checkSsl
 * @property integer $checkRise
 * @property integer $checkFall
 * @property boolean $disableHttp2
 * @property boolean $http2Only
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Target extends Entity
{
    protected $dates = [
        'createdAt',
        'updatedAt'
    ];
}
