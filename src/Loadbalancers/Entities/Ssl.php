<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $bindsId
 * @property bool $enabled
 * @property bool $allowTlsV1
 * @property bool $allowTlsV11
 * @property bool $disableHttp2
 * @property bool $http2Only
 * @property bool $customCiphers
 * @property bool $customTls13Ciphers
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Ssl extends Entity
{
    protected $dates = [
        'createdAt',
        'updatedAt'
    ];
}
