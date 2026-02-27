<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\HostSpec;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class HostSpecClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<HostSpec> */
    use PageItems;

    protected $collectionPath = 'v2/host-specs';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'cpu_type' => 'cpuType',
            'cpu_sockets' => 'cpuSockets',
            'cpu_cores' => 'cpuCores',
            'cpu_clock_speed' => 'cpuSpeed',
            'ram_capacity' => 'ramCapacity',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new HostSpec(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getByAvailabilityZoneId($availabilityZoneId, $filters = [])
    {
        $originalCollection = $this->collectionPath;

        $this->collectionPath = 'v2/availability-zones/'.$availabilityZoneId.'/host-specs';
        $items = $this->getAll($filters);

        $this->collectionPath = $originalCollection;

        return $items;
    }
}
