<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $email
 * @property array $nameservers
 * @property boolean $customSoaAllowed
 * @property boolean $customBaseNsAllowed
 * @property object $customAxfr
 * @property boolean $delegationAllowed
 * @property string $product
 */
class Settings extends Entity
{
}
