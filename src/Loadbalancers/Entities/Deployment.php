<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $clusterId
 * @property bool $successful
 * @property string $requestedByType
 * @property string $requestedById
 * @property int $pssId
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Deployment extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
