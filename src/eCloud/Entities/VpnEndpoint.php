<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string vpnServiceId
 * @property string floatingIpId
 * @property string $sync
 */
class VpnEndpoint extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
