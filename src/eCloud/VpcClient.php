<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Vpc;

class VpcClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpcs';

    public function loadEntity($data)
    {
        return new Vpc(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'region_id' => 'regionId',
            'support_enabled' => 'supportEnabled',
            'console_enabled' => 'consoleEnabled',
            'advanced_networking' => 'advancedNetworkingEnabled',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }
}
