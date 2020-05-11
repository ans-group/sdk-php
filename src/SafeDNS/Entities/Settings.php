<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Domains\Entities\Nameserver;
use UKFast\SDK\Entity;

/**
 * @property string $email
 * @property \UKFast\SDK\Domains\Entities\Nameserver[] $nameservers
 * @property boolean $customSoaAllowed
 * @property boolean $customBaseNsAllowed
 * @property \UKFast\SDK\SSL\Entities\CustomAxfr $customAxfr
 * @property boolean $delegationAllowed
 * @property string $product
 */
class Settings extends Entity
{
}
