<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id Host Identifier
 * @property string $name Host name
 * @property object $cpu CPU specification
 * @property object $ram RAM specification
 * @property int $solutionId Solution ID
 * @property int $podId Pod ID
 */
class Host extends Entity
{
}
