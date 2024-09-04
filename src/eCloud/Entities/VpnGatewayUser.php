<?php

namespace UKFast\SDK\eCloud\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string vpnGatewayId
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 */
class VpnGatewayUser extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpn_gateway_id' => 'vpnGatewayId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
