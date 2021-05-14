<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $policyId
 * @property string $source
 * @property string $destination
 * @property string $action
 * @property int $sequence
 * @property bool $enabled
 * @property string $createdAt
 * @property string $updatedAt
 */
class NetworkRule extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
