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
     * Create a new virtual machine
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $response = $this->post("v1/vms", json_encode($data), [
            'Content-Type'=>'application/json'
        ]);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

    /**
     * Create a clone of an existing virtual machine
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function createClone($id, array $data = [])
    {
        $response = $this->post("v1/vms/$id/clone", json_encode($data), [
            'Content-Type'=>'application/json'
        ]);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

    /**
     * Clone virtual machine to template
     * @param $id
     * @param array $data
     * @return bool
     */
    public function cloneToTemplate($id, array $data)
    {
        $response = $this->post("v1/vms/$id/clone-to-template", json_encode($data), [
            'Content-Type'=>'application/json'
        ]);

        return $response->getStatusCode() == 202;
    }

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
     * Power Reset a Virtual Machine
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

    /**
     * Destroy a virtual machine
     *
     * @param string $id
     * @return bool
     */
    public function destroy($id)
    {
        $response = $this->delete("v1/vms/$id");
        return $response->getStatusCode() == 202;
    }
}
