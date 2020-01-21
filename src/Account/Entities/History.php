<?php

namespace UKFast\SDK\Account\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $contactId
 * @property string $username
 * @property string $created_at
 * @property string $reason
 * @property string $ip
 * @property string $url
 * @property string $userAgent
 */
class History extends Entity
{
    protected $dates = ['createdAt'];
}
