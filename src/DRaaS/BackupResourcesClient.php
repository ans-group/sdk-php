<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\BackupResources;
use UKFast\SDK\Entities\ClientEntityInterface;

class BackupResourcesClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'used_quota' => 'usedQuota'
    ];

    public function loadEntity($data)
    {
        return new BackupResources($this->apiToFriendly($data, static::MAP));
    }
}
