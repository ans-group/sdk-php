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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/hosts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Host($body->data);
    }
}
