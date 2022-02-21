<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;

use UKFast\SDK\eCloud\Entities\IpAddress;
use UKFast\SDK\Traits\PageItems;

class IpAddressesClient extends Client implements ClientEntityInterface
{
    use PageItems;

    private $collectionPath = "v2/ip-addresses";

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'ip_address' => 'ipAddress',
            'network_id' => 'networkId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new IpAddress(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
