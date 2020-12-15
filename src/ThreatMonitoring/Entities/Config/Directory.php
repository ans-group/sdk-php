<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities\Config;

use UKFast\SDK\Entity;

/**
 * @property bool $checkAll
 * @property bool $checkAttrs
 * @property bool $checkGroup
 * @property bool $checkInode
 * @property bool $checkMd5sum
 * @property bool $checkMtime
 * @property bool $checkOwner
 * @property bool $checkPerm
 * @property bool $checkSha1sum
 * @property bool $checkSha256sum
 * @property bool $checkSize
 * @property bool $checkSum
 * @property bool $critical
 * @property bool $editable
 * @property bool $followSymbolicLink
 * @property string $group
 * @property bool $ignored
 * @property string $path
 * @property bool $realtime
 * @property string $recursionLevel
 * @property bool $reportChanges
 * @property string $restrict
 * @property bool $whodata
 */
class Directory extends Entity
{
}
