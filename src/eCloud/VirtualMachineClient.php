<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Page;
use UKFast\SDK\eCloud\Entities\VirtualMachine;
use UKFast\SDK\eCloud\Entities\Hdd;

class VirtualMachineClient extends Client
{
    const VM_MAP = [
        'computername' => 'computerName',
        'hdd_disks' => 'disks',
        'power_status' => 'power',
        'tools_status' => 'tools',
        'solution_id' => 'solutionId',
        'pod_id' => 'podId',
        'ad_domain_id' => 'adDomainId',
    ];

    const HDD_MAP = [

    ];


    /**
     * Gets a paginated response of all Virtual Machines
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/vms', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets array of all Virtual Machines
     *
     * @param array $filters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Create a new virtual machine
     *
     * @param VirtualMachine $virtualMachine
     * @return VirtualMachine
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     *
     * @param $id
     * @param $name
     * @param string $type
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function powerReset($id)
    {
        $response = $this->put("v1/vms/$id/power-reset");
        return $response->getStatusCode() == 204;
    }

    /**
     * Shutdown the Virtual Machine Guest
     *
     * @param int $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function guestShutdown($id)
    {
        $response = $this->put("v1/vms/$id/power-shutdown");
        return $response->getStatusCode() == 204;
    }

    /**
     * Restart a Virtual Machine Guest
     *
     * @param int $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete("v1/vms/$id");
        return $response->getStatusCode() == 202;
    }

    /**
     * load entity from api response
     * @param $item
     * @return VirtualMachine
     */
    private function loadEntity($item) {
        if (isset($item->hdd_disks) && is_array($item->hdd_disks)) {
            // hydrate HDD entities
            foreach($item->hdd_disks as $key => $hdd) {
                $item->hdd_disks[$key] = new Hdd($this->apiToFriendly($hdd, static::HDD_MAP));
            };
        }

        // remap primary IP addresses
        $item->ipAddresses = (object) [
            'internal' => $item->ip_internal,
            'external' => $item->ip_external,
        ];
        unset($item->ip_internal, $item->ip_external);

        return new VirtualMachine($this->apiToFriendly($item, static::VM_MAP));
    }
}
