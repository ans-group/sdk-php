<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * Class VirtualMachine
 * @package UKFast\eCloud\Entities
 *
 * @property int $id
 * @property string $name
 * @property string $status
 *
 * @property string $hostname
 * @property string $computerName
 *
 * @property int $cpu
 * @property int $ram
 *
 * @property int $hdd
 * @property array $disks
 * @property int $datastoreId
 *
 * @property string $ipAddresses
 *
 * @property string $template
 * @property string $platform
 *
 * @property boolean $backup
 * @property boolean $support
 *
 * @property string $environment
 * @property int $podId
 * @property int $solutionId
 *
 * @property int $adDomainId
 *
 * @property string $power
 * @property string $tools
 *
 * @property array $credentials
 */
class VirtualMachine extends Entity
{

}
