<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $balance
 * @property string $mode
 * @property bool $close
 * @property bool $sticky
 * @property string $cookieOpts
 * @property int $timeoutConnect
 * @property string $source
 * @property int $timeoutServer
 */
class Backend extends Entity
{
}
