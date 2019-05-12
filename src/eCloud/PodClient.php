<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Pod;

class PodClient extends Client
{
    /**
     * Gets a paginated response of Pods
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/pods", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Pod($item);
        });

        return $page;
    }

    /**
     * Gets an individual Pod
     *
     * @param int $id
     * @return Pod
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/pods/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Pod($body->data);
    }
}
