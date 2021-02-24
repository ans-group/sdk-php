<?php

namespace UKFast\SDK\DDoSX\Entities\AccessLog;

use UKFast\SDK\Entity;

/**
 * @property string    $id
 * @property Request   $request
 * @property Cdn       $cdn
 * @property Origin    $origin
 * @property Response  $response
 * @property \DateTime $createdAt
 */
class AccessLog extends Entity
{
    protected $dates = [
        'createdAt',
    ];
}
