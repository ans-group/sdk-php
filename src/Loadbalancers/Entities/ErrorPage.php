<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int|null $targetGroupId
 * @property int|null $listenerId
 * @property string $statusCodes
 * @property string $content
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class ErrorPage extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
