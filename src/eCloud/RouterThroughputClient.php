<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\RouterThroughput;

class RouterThroughputClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/router-throughputs';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'availability_zone_id' => 'availabilityZoneId',
            'committed_bandwidth' => 'committedBandwidth',
            'burst_size' => 'burstSize',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new RouterThroughput(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
