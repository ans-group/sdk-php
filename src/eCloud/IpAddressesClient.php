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
        return IpAddress::$entityMap;
    }

    public function loadEntity($data)
    {
        return new IpAddress(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
