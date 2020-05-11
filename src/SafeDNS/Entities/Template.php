<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entity;

/**
 * @property integer $id
 * @property string $name
 * @property boolean $default
 * @property \DateTime $createdAt
 */
class Template extends Entity
{
    protected $dates = ['createdAt'];
}
