<?php

namespace UKFast\SDK\DDoSX\Entities;

use UKFast\SDK\Entity;

/**
 * @property string   $id
 * @property int|null $ukfastSslId
 * @property string[] $domains
 * @property string   $friendlyName
 * @property string   $expiresAt
 */
class Ssl extends Entity
{
    /**
     * Fields to convert to \DateTime objects
     *
     * @var array
     */
    protected $dates = ['expiresAt'];
}
