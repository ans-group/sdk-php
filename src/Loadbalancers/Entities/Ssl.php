<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $bindsId
 * @property bool $enabled
 * @property array $allowTls
 * @property bool $disableHttp2
 * @property bool $onlyHttp2
 * @property bool $customCiphers
 * @property bool $customTls13Ciphers
 */
class Ssl extends Entity
{
}
