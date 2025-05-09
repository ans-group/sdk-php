<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\MonitoringGatewaySpecification;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class MonitoringGatewaySpecificationClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/monitoring-gateway-specifications';

    public function getEntityMap()
    {
        return MonitoringGatewaySpecification::$entityMap;
    }

    public function loadEntity($data)
    {
        return new MonitoringGatewaySpecification(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
