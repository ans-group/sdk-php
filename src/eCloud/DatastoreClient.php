<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Datastore;

class DatastoreClient extends Client
{
    /**
     * Gets a paginated response of Datastores
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
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
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/datastores/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Datastore($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Datastores
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getBySolutionId($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Datastore($item);
        });

        return $page;
    }
}
