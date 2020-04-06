<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entity;

/**
 * @property integer   $id
 * @property string    $zone
 * @property string    $name
 * @property string    $type
 * @property string    $content
 * @property int       $ttl
 * @property int       $priority
 * @property \DateTime $updatedAt
 */
class Record extends Entity
{
    protected $dates = ['updatedAt'];
}
