<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\Pod;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class PodClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'name' => 'name',
    ];

    /**
     * Get a paginated response from a collection
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/pods', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Get a single item from the collection
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $response = $this->get('v1/pods' . '/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return Pod
     */
    public function loadEntity($data)
    {
        return new Pod($this->apiToFriendly($data, static::MAP));
    }
}
