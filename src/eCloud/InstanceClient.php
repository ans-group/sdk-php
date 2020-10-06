<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
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
            'appliance_id' => 'applianceId',
            'locked' => 'locked',
            'vcpu_cores' => 'vcpuCores',
            'ram_capacity' => 'ramCapacity',
            'volume_capacity' => 'volumeCapacity',
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
}
