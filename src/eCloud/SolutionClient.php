<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Solution;

class SolutionClient extends Client
{
    /**
     * Gets a paginated response of all Solutions
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/solutions', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Solution($item);
        });

        return $page;
    }

    /**
     * Gets an individual Solution
     *
     * @param int $id
     * @return Solution
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/solutions/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Solution($body->data);
    }
}
