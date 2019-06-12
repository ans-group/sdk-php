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
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/vms', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new VirtualMachine($item);
        });

        return $page;
    }

    /**
     * Gets array of all Virtual Machines
     *
     * @param array $filters
     * @return array
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $virtualMachines = $page->getItems();
        if ($page->totalPages() == 1) {
            return $virtualMachines;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $virtualMachines = array_merge(
                $virtualMachines,
                $page->getItems()
            );
        }

        return $virtualMachines;
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

    /**
     * Create a new virtual machine
     *
     * @param VirtualMachine $virtualMachine
     * @return VirtualMachine
     */
    public function create(VirtualMachine $virtualMachine)
    {
        $data = [
            'environment' => $virtualMachine->environment,

            'name' => $virtualMachine->name,
            'computername' => $virtualMachine->computerName,
        ];

        if ($virtualMachine->environment != 'Public') {
            $data['solution_id'] = $virtualMachine->solutionId;
        }


        // template
        if (!empty($virtualMachine->template)) {
            $data['template'] = $virtualMachine->template;
        }


        // set compute
        $data = array_merge($data, [
            'cpu' => $virtualMachine->cpu,
            'ram' => $virtualMachine->ram,
        ]);


        // set storage
        $data = array_merge($data, [
            'hdd' => $virtualMachine->hdd,
        ]);

        if (!empty($virtualMachine->disks)) {
            foreach ($virtualMachine->disks as $disk) {
                $data['hdd_disks'][] = [
                    'name' => $disk->name,
                    'capacity' => $disk->capacity,
                ];
            }
        }

        if (!empty($virtualMachine->datastoreId)) {
            $data['datastore_id'] = $virtualMachine->datastoreId;
        }


        // set network


        $response = $this->post("v1/vms", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        $body = $this->decodeJson($response->getBody()->getContents());

        $virtualMachine->id = $body->data->id;
        $virtualMachine->status = $body->data->status;

        $virtualMachine->credentials = $body->data->credentials;

        return $virtualMachine;
    }

    /**
     * Update an existing virtual machine
     *
     * @param VirtualMachine $virtualMachine
     * @return bool
     */
    public function update(VirtualMachine $virtualMachine)
    {
        $data = [
            'name' => $virtualMachine->name,

            'cpu' => $virtualMachine->cpu,
            'ram' => $virtualMachine->ram,
            'hdd' => $virtualMachine->hdd,
        ];

        $response = $this->put("v1/vms/".$virtualMachine->id."", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        return $response->getStatusCode() == 202;
    }

    /**
     * Create a clone of an existing virtual machine
     * @param $id
     * @param null $name
     * @return mixed
     */
    public function createClone($id, $name = null)
    {
        $data = [];

        if (!is_null($name)) {
            $data['name'] = $name;
        }

        $response = $this->post("v1/vms/$id/clone", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

    /**
     * Clone virtual machine to template
     * @param $id
     * @param $name
     * @param string $type
     * @return bool
     */
    public function cloneToTemplate($id, $name, $type = null)
    {
        $data = [
            'template_name' => $name,
        ];

        if (!is_null($type)) {
            $data['template_type'] = $type;
        }

        $response = $this->post("v1/vms/$id/clone-to-template", json_encode($data), [
            'Content-Type' => 'application/json'
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
