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
 * @property bool $allowTlsv1
 * @property bool $allowTlsv11
 * @property bool $disallowTlsv12
 * @property bool $disableHttp2
 * @property bool $http2Only
 * @property string $customCiphers
 */
class Listener extends Entity
{
}
