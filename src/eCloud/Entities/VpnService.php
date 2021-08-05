<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string routerId
 * @property string vpcId
 * @property string $sync
 */
class VpnService extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
