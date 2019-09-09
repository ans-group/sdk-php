<?php

namespace UKFast\SDK\eCloud;



use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreClient extends Client implements ClientEntityInterface
{
    /**
     * Create a datastore
     * @param Datastore $datastore
     * @return bool
     */
    public function create(Datastore $datastore)
    {
        $data = json_encode(
            [
                'name' => $datastore->name,
                'solution_id' => $datastore->solutionId,
	            'capacity' => $datastore->capacity
            ]
        );

        if (!empty($datastore->siteId)) {
            $data['site_id'] = $datastore->siteId;
        }

        $response = $this->post(
            'v1/datastores',
            $data
        );

        return $response->getStatusCode() == 202;
    }

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
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Expand a datastore
     * @param $id - ID of the datastore
     * @param $sizeGB - New size of the datastore
     * @return bool
     */
    public function expand($id, $sizeGB)
    {
        $data = json_encode(['size_gb' => $sizeGB]);

        $response = $this->post(
            'v1/datastores/'. $id .'/expand',
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
                'capacity' => $data->status,
                'allocated' => $data->allocated,
                'available' => $data->available,
                'solutionId' => $data->solution_id,
                'siteId' => $data->site_id
        ]);
    }
}
