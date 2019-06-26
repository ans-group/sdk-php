<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Site;

class SiteClient extends Client
{
    /**
     * Gets a paginated response of Sites
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/sites", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Site($item);
        });

        return $page;
    }

    /**
     * Gets an individual Site
     *
     * @param int $id
     * @return Site
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/sites/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Site($body->data);
    }
}
