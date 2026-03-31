<?php

namespace UKFast\SDK\DRaaS\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string|null $name
 * @property string|null $status
 * @property array<int, array{name: string}>|null $vms
 */
class RecoveryPlan extends Entity
{
    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'status' => 'status',
        'vms' => 'vms',
    ];
}
