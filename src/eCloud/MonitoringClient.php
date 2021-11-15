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
            'id'   => 'id',
            'name' => 'name',
        ];
    }

    /**
     * @param $data
     * @return Instance
     */
    public function loadEntity($data)
    {
        return new Instance(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @param string $vmId
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvailableMetrics(string $vmId)
    {
        try {
            $data = $this->get($this->collectionPath . "/{$vmId}");
        } catch (\Exception $e) {
            return [];
        }
        return $data->getBody()->getContents();
    }

    /**
     * @param int $widgetId
     * @param $additionalQueryParams
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMetrics(int $widgetId, $additionalQueryParams)
    {
        try {
            $data = $this->get($this->collectionPath . "/{$widgetId}/widget?{$additionalQueryParams}");
        } catch (\Exception $e) {
            return [];
        }
        return $data->getBody()->getContents();
    }

    /**
     * @param int $pingId
     * @param int $instanceId
     * @param $additionalQueryParams
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPingMetrics(int $pingId, int $instanceId, $additionalQueryParams)
    {
        try {
            $data = $this->get($this->collectionPath . "/{$pingId}/{$instanceId}/ping?{$additionalQueryParams}");
        } catch (\Exception $e) {
            return $e->getMessage();
            return [];
        }
        return $data->getBody()->getContents();
    }
}
