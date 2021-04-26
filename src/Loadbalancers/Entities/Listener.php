<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $clusterId
 * @property bool $hstsEnabled
 * @property string $mode
 * @property int $hstsMaxAge
 * @property bool $close
 * @property bool $redirectHttps
 * @property string $defaultTargetGroupId
 * @property bool $accessIsAllowList
 */
class Listener extends Entity
{
}
