<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;

use UKFast\SDK\eCloud\Entities\IpAddress;
use UKFast\SDK\Traits\PageItems;

class IpAddressesClient extends Client implements ClientEntityInterface
{
    use PageItems;

    private $collectionPath = "v2/ip-addresses";

    public function getEntityMap()
    {
        return IpAddress::$entityMap;
    }

    public function loadEntity($data)
    {
        return new IpAddress(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

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
        $nicClient = new NicClient();
        $page->serializeWith(function ($item) use ($nicClient) {
            return $nicClient->loadEntity($item);
        });
        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, $perPage);
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
}
