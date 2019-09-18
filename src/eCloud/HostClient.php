<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Page;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\eCloud\Entities\Host;


class HostClient extends Client implements ClientEntityInterface
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
            return $this->loadEntity($item);
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
        return $this->loadEntity($body->data);
    }

    /**
     * Load an instance of Host from API data
     * @param $data
     * @return Host
     */
    public function loadEntity($data)
    {
        return new Host(
            [
                'id' => $data->id,
                'name' => $data->name,
                'cpu' => $data->cpu,
                'ram' => $data->ram,
                'solutionId' => $data->solution_id,
                'podId' => $data->pod_id
            ]
        );
    }
}
