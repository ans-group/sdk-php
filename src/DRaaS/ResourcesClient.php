<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\Resources;
use UKFast\SDK\Entities\ClientEntityInterface;

class ResourcesClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'used_quota' => 'usedQuota'
    ];

    public function loadEntity($data)
    {
        return new Resources($this->apiToFriendly($data, static::MAP));
    }
}
