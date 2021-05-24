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
 * @property int $timeoutsConnect
 * @property int $timeoutsServer
 * @property string $monitorUrl
 * @property string $monitorMethod
 * @property string $monitorHost
 * @property string $monitorHttpVersion
 * @property string $monitorExpect
 * @property bool $monitorTcpMonitoring
 * @property string $customOptions
 * @property int $checkPort
 * @property bool $sendProxy
 * @property bool $sendProxyV2
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class TargetGroup extends Entity
{
    protected $dates = [
        'createdAt',
        'updatedAt'
    ];
}
