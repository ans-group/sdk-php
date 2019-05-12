<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Host;

class HostClient extends Client
{
    /**
     * Gets a paginated response of Hosts
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/hosts", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Host($item);
        });

        return $page;
    }

    /**
     * Gets an individual Host
     *
     * @param int $id
     * @return Host
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/hosts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Host($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Hosts
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getBySolutionId($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/hosts", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Host($item);
        });

        return $page;
    }
}
