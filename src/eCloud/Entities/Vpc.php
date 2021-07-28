<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $regionId
 * @property boolean $supportEnabled
 * @property boolean $consoleEnabled
 * @property boolean $advancedNetworkingEnabled
 * @property string $createdAt
 * @property string $updatedAt
 */
class Vpc extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
