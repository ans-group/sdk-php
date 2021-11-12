<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Instance;

class MonitoringClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/monitoring';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
        ];
    }

    public function loadEntity($data)
    {
        return new Instance(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getAvailableMetrics(string $vmId)
    {
        try {
            $data = $this->get($this->collectionPath . "/{$vmId}");
        } catch (\Exception $e) {
            return [];
        }
        return $data->getBody()->getContents();
    }

    public function getMetrics(int $widgetId, $additionalQueryParams)
    {
        try {
            $data = $this->get($this->collectionPath . "/{$widgetId}/widget?{$additionalQueryParams}");
        } catch (\Exception $e) {
            return [];
        }
        return $data->getBody()->getContents();
    }
}
