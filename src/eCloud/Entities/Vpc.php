<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property integer $clientId
 * @property string $regionId
 * @property boolean $supportEnabled
 * @property boolean $consoleEnabled
 * @property boolean $advancedNetworkingEnabled
 * @property object{
 *     enabled: boolean
 * } $draas
 * @property string $createdAt
 * @property string $updatedAt
 */
class Vpc extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'client_id' => 'clientId',
        'region_id' => 'regionId',
        'support_enabled' => 'supportEnabled',
        'console_enabled' => 'consoleEnabled',
        'advanced_networking' => 'advancedNetworkingEnabled',
        'draas' => 'draas',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
