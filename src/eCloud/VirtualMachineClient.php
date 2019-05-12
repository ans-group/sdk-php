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
        $response = $this->get("v1/vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new VirtualMachine($body->data);
    }

//    /**
//     * Gets a paginated response of a Solutions Virtual Machines
//     *
//     * @param int $id
//     * @param int $page
//     * @param int $perPage
//     * @param array $filters
//     * @return Page
//     */
//    public function getBySolutionId($id, $page = 1, $perPage = 15, $filters = [])
//    {
//        $filters = array_merge([
//            'solution_id' => $id,
//        ], $filters);
//        return $this->getAll($page, $perPage, $filters);
//    }

    /**
     * Power On a Virtual Machine
     *
     * @param int $id
     * @return bool
     */
    public function powerOn($id)
    {
        $response = $this->put("v1/vms/$id/power-on");
        return $response->getStatusCode() == 204;
    }

    /**
     * Power Off a Virtual Machine
     *
     * @param int $id
     * @return bool
     */
    public function powerOff($id)
    {
        $response = $this->put("v1/vms/$id/power-off");
        return $response->getStatusCode() == 204;
    }

    /**
     * Reset a Virtual Machine
     *
     * @param int $id
     * @return bool
     */
    public function powerReset($id)
    {
        $response = $this->put("v1/vms/$id/power-reset");
        return $response->getStatusCode() == 204;
    }

    /**
     * Guest Shutdown a Virtual Machine
     *
     * @param int $id
     * @return bool
     */
    public function guestShutdown($id)
    {
        $response = $this->put("v1/vms/$id/power-shutdown");
        return $response->getStatusCode() == 204;
    }

    /**
     * Guest Restart a Virtual Machine
     *
     * @param int $id
     * @return bool
     */
    public function guestRestart($id)
    {
        $response = $this->put("v1/vms/$id/power-restart");
        return $response->getStatusCode() == 204;
    }
}
