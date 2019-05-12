<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Solution;
use UKFast\eCloud\Entities\Template;
use UKFast\eCloud\Entities\VirtualMachine;

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

    /**
     * Gets a paginated response of a Solutions Virtual Machines
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getVirtualMachines($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/vms", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new VirtualMachine($item);
        });

        return $page;
    }

    /**
     * Gets a paginated response of a Solutions Templates
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getTemplates($id, $page = 1, $perPage = 15, $filters = [])
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
    public function getTemplateByName($id, $name)
    {
        $response = $this->request("GET", "v1/solutions/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Template($body->data);
    }
}
