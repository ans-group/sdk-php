<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreClient extends Client implements ClientEntityInterface
{
    /**
     * Gets a paginated response of Datastores
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Datastore>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Expand a datastore
     * @param Datastore $datastore - A Datastore entity with capacity set to the required new size.
     * @return bool
     */
    public function expand(Datastore $datastore)
    {
        $data = json_encode(['capacity' => $datastore->capacity]);

        $response = $this->post(
            'v1/datastores/'. $datastore->id .'/expand',
            $data
        );

        return $response->getStatusCode() == 202;
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
        return $this->loadEntity($body->data);
    }


    /**
     * Load an instance of Datastore from API data
     * @param $data
     * @return Datastore
     */
    public function loadEntity($data)
    {
        return new Datastore(
            [
                'id' => $data->id,
                'name' => $data->name,
                'status' => $data->status,
                'capacity' => $data->capacity,
                'allocated' => $data->allocated,
                'available' => $data->available,
                'solutionId' => $data->solution_id,
                'siteId' => $data->site_id
            ]
        );
    }
}
