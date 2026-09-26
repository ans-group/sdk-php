<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * The account's domain settings: default nameservers for new registrations
 * and default renewal behaviour.
 *
 * @property string|null $nameserverOne
 * @property string|null $nameserverTwo
 * @property string|null $nameserverThree
 * @property bool $autoRenew
 * @property int $autoRenewTerm
 */
class Settings extends Entity
{
}
