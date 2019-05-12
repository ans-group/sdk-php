<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Template;

class TemplateClient extends Client
{
    /**
     * Gets a paginated response of a Solutions Templates
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getBySolutionId($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/templates", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Template($item);
        });

        return $page;
    }

    /**
     * Gets an individual Solution Template
     *
     * @param int $id
     * @param $name
     * @return Template
     */
    public function getSolutionTemplateByName($id, $name)
    {
        $response = $this->request("GET", "v1/solutions/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Template($body->data);
    }
}
