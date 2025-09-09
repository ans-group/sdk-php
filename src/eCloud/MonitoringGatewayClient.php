<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\MonitoringGateway;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class MonitoringGatewayClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<MonitoringGateway> */
    use PageItems;

    protected $collectionPath = 'v2/monitoring-gateways';

    public function getEntityMap()
    {
        return MonitoringGateway::$entityMap;
    }

    public function loadEntity($data)
    {
        return new MonitoringGateway(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
