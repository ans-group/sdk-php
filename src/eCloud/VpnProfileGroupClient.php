<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnProfileGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnProfileGroupClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpn-profile-groups';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new VpnProfileGroup(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
