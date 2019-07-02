<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreClient extends Client
{
    /**
     * Gets a paginated response of Datastores
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Datastore($item);
        });

        return $page;
    }

    /**
     * Gets an individual Datastore
     *
     * @param int $id
     * @return Datastore
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/datastores/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Datastore($body->data);
    }
}
