<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * A TLD the account can register, e.g. ".co.uk", with its registration,
 * renewal, transfer and privacy rules.
 *
 * @property string $name
 * @property string|null $description
 * @property string|null $categoryName
 * @property int|null $categoryOrder
 * @property bool|null $registrationRealtime
 * @property string|null $registrationRequirements
 * @property bool|null $registrationValidation
 * @property bool|null $registrationIrtp
 * @property int|null $registrationMinTerm
 * @property bool|null $renewalAuto
 * @property int|null $renewalMinTerm
 * @property int|null $renewalMilestone
 * @property int|null $transferMinTerm
 * @property bool|null $privacyAvailable
 * @property bool|null $privacyFee
 * @property string|null $createdAt
 * @property string|null $updatedAt
 */
class Tld extends Entity
{
}
