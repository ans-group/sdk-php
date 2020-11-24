<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $clusterId
 * @property string $balance
 * @property string $mode
 * @property bool $close
 * @property bool $sticky
 * @property string $cookieOpts
 * @property string $source
 * @property int $timeoutConnect
 * @property int $timeoutServer
 * @property string $monitorUrl
 * @property string $monitorMethod
 * @property string $monitorHost
 * @property string $monitorHttpVersion
 * @property string $monitorExpect
 * @property bool $monitorTcpMonitoring
 */
class TargetGroup extends Entity
{
}
