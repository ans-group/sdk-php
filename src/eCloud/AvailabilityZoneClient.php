<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\AvailabilityZone;

class AvailabilityZoneClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/availability-zones';

    public function loadEntity($data)
    {
        return new AvailabilityZone(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code',
            'datacentre_site_id' => 'datacentreSiteId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }
}
