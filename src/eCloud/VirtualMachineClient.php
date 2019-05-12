<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\VirtualMachine;

class VirtualMachineClient extends Client
{
    /**
     * Gets a paginated response of all Virtual Machines
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/vms', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new VirtualMachine($item);
        });

        return $page;
    }

    /**
     * Gets an individual Virtual Machine
     *
     * @param int $id
     * @return VirtualMachine
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new VirtualMachine($body->data);
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
    public function getBySolutionId($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/vms", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new VirtualMachine($item);
        });

        return $page;
    }
}
