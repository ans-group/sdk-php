<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\eCloud\Entities\Nic;
use UKFast\SDK\Traits\PageItems;

class NicClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/nics';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'mac_address' => 'macAddress',
            'instance_id' => 'instanceId',
            'network_id' => 'networkId',
            'ip_address' => 'ipAddress',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Nic(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * Assigns an IP address with a NIC
     * @param $id
     * @param $ipAddressId
     * @return bool
     */
    public function assignIpAddress($id, $ipAddressId)
    {
        $response = $this->post(
            $this->collectionPath . '/' . $id . '/ip-addresses',
            json_encode([ 'ip_address_id' => $ipAddressId ])
        );
        return $response->getStatusCode() == 202;
    }

    /**
     * Get the IP address records associated with a NIC
     * @param $id
     * @return array
     */
    public function getIpAddresses($id)
    {
        $page = $this->paginatedRequest(
            $this->collectionPath . '/' . $id . '/ip-addresses',
            $currentPage = 1,
            $perPage = 15
        );

        if ($page->totalItems() == 0) {
            return [];
        }

        $ipAddressClient = new IpAddressesClient();
        $page->serializeWith(function ($item) use ($ipAddressClient) {
            return $ipAddressClient->loadEntity($item);
        });


        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, $perPage);
            $page->serializeWith(function ($item) use ($ipAddressClient) {
                return $ipAddressClient->loadEntity($item);
            });
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }
        return $items;
    }
}
