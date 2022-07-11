<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string vpcId
 * @property string $vpnProfileGroupId
 * @property string $vpnServiceId
 * @property string $vpnEndpointId
 * @property string $remoteIp
 * @property string $psk
 * @property string $remoteNetworks
 * @property string $localNetworks
 * @property string $sync
 */
class VpnSession extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
