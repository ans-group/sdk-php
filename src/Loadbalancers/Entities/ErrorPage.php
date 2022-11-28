<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $targetGroupId
 * @property string $statusCodes
 * @property string $content
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class ErrorPage extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
