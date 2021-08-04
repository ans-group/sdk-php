<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Exception\UKFastException;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Instance;

class InstanceClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/instances';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'image_id' => 'imageId',
            'platform' => 'platform',
            'vcpu_cores' => 'vcpuCores',
            'ram_capacity' => 'ramCapacity',
            'volume_capacity' => 'volumeCapacity',
            'locked' => 'locked',
            'status' => 'status',
            'online' => 'online',
            'agent_running' => 'agentRunning',
            'backup_enabled' => 'backupEnabled',
            'host_group_id' => 'hostGroupId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Instance(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * Get array of instance credentials
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCredentials($id)
    {
        $currentPage = 1;
        $perPage = 15;

        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/credentials',
            $currentPage,
            $perPage
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $credentialsClient = new CredentialsClient;
        $page->serializeWith(function ($item) use ($credentialsClient) {
            return $credentialsClient->loadEntity($item);
        });

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/credentials',
                $currentPage++,
                $perPage
            );

            $page->serializeWith(function ($item) use ($credentialsClient) {
                return $credentialsClient->loadEntity($item);
            });

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    /**
     * Get array of instance volumes
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVolumes($id)
    {
        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/volumes',
            $currentPage = 1,
            $perPage = 15
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $volumeClient = new VolumeClient;
        $page->serializeWith(function ($item) use ($volumeClient) {
            return $volumeClient->loadEntity($item);
        });

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/volumes',
                $currentPage++,
                $perPage
            );

            $page->serializeWith(function ($item) use ($volumeClient) {
                return $volumeClient->loadEntity($item);
            });

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    /**
     * Get array of instance nics
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNics($id)
    {
        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/nics',
            $currentPage = 1,
            $perPage = 15
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $nicClient = new NicClient;
        $page->serializeWith(function ($item) use ($nicClient) {
            return $nicClient->loadEntity($item);
        });

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->paginatedRequest(
                $this->collectionPath . '/' . $id . '/volumes',
                $currentPage++,
                $perPage
            );

            $page->serializeWith(function ($item) use ($nicClient) {
                return $nicClient->loadEntity($item);
            });

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    public function getFloatingIps($instanceId)
    {
        $nics = $this->getNics($instanceId);
        if (empty($nics)) {
            return [];
        }

        $nicFilter = [];
        foreach ($nics as $nic) {
            $nicFilter[] = $nic->id;
        }

        return $this->floatingIps()->getAll([
            'resourceId:in' => implode(',', $nicFilter),
        ]);
    }

    public function getByVolumeId($volumeId)
    {
        $page = $this->paginatedRequest('v2/volumes/'.$volumeId.'/instances', 1, 100);
        if ($page->totalItems() == 0) {
            return [];
        }

        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        $collection = $page->getItems();
        if ($page->totalPages() == 1) {
            return $collection;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, 100);
            $collection = array_merge(
                $collection,
                $page->getItems()
            );
        }

        return $collection;
    }

    public function getConsoleSession($id)
    {
        $response = $this->post($this->collectionPath . '/' . $id . '/console-session');

        if ($response->getStatusCode() != 200) {
            throw new UKFastException('unexpected response code: ' . $response->getStatusCode());
        }

        return $this->decodeJson($response->getBody()->getContents())->data;
    }
}
