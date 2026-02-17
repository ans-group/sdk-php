<?php

namespace UKFast\SDK\DRaaS\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $status
 * @property array<int, array{name: string}>|null $vms
 */
class RecoveryPlan extends Entity
{
    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'status' => 'status',
        'vms' => 'vms',
    ];
}
