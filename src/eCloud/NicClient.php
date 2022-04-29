<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\eCloud\Entities\Nic;

class NicClient extends Client implements ClientEntityInterface
{
    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'ip_address' => 'ipAddress',
            'mac_address' => 'macAddress',
            'instance_id' => 'instanceId',
            'network_id' => 'networkId',
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
     * Detaches an IP address from a NIC
     * @param $id
     * @param $ipAddressId
     * @return bool
     */
    public function detachIpAddress($id, $ipAddressId)
    {
        $response = $this->delete($this->collectionPath . '/' . $id . '/ip-addresses/' . $ipAddressId);
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

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, $perPage);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }
        return $items;
    }
}
