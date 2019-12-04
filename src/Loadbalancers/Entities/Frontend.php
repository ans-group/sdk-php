<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vipsId
 * @property int $port
 * @property bool $hstsEnabled
 * @property string $mode
 * @property int $hstsMaxAge
 * @property bool $close
 * @property bool $redirectHttps
 * @property string $defaultBackendId
 */
class Frontend extends Entity
{
}
