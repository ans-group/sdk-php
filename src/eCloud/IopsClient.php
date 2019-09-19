<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Iops;

class IopsClient extends Client implements ClientEntityInterface
{
    /**
     * Gets a paginated response of Iops
     * @param int $page Page number
     * @param int $perPage Number of items to return per page
     * @param array $filters Filter to apply
     * @return int|Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/iops", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual Iops entity
     *
     * @param int $id
     * @return Iops
     */
    public function getById($id)
    {
        $response = $this->get("v1/iops/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }


    /**
     * Load an instance of Iops from API data
     * @param $data
     * @return Iops
     */
    public function loadEntity($data)
    {
        return new Iops(
            [
                'id' => $data->id,
                'name' => $data->name,
                'limit' => $data->slimit,
            ]
        );
    }
}
