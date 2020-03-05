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
        ];


        // environment
        if ($virtualMachine->environment == 'Public') {
            $data['pod_id'] = $virtualMachine->podId;
        } elseif ($virtualMachine->environment != 'Public') {
            $data['solution_id'] = $virtualMachine->solutionId;

            if (!empty($virtualMachine->siteId)) {
                $data['site_id'] = $virtualMachine->siteId;
            }
        }


        // template
        if (!empty($virtualMachine->template)) {
            $data['template'] = $virtualMachine->template;
        } elseif (!empty($virtualMachine->applianceId)) {
            $data['appliance_id'] = $virtualMachine->applianceId;

            if (!empty($virtualMachine->applianceParameters) && is_array($virtualMachine->applianceParameters)) {
                foreach ($virtualMachine->applianceParameters as $key => $value) {
                    $data['parameters'][] = [
                        'key' => $key,
                        'value' => $value,
                    ];
                }
            }
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

        if (!empty($virtualMachine->disks) && is_array($virtualMachine->disks)) {
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
        if (!empty($virtualMachine->networkId)) {
            $data['network_id'] = $virtualMachine->networkId;
        }

        if ($virtualMachine->externalIpRequired == true) {
            $data['external_ip_required'] = true;
        }


        // additional options
        if (!empty($virtualMachine->computerName)) {
            $data['computername'] = $virtualMachine->computerName;
        }

        if (!empty($virtualMachine->sshKeys)) {
            $data['ssh_keys'] = $virtualMachine->sshKeys;
        }

        if (!empty($virtualMachine->tags)) {
            $data['tags'] = $virtualMachine->tags;
        }

        if (!empty($virtualMachine->adDomainId)) {
            $data['ad_domain_id'] = true;
        }

        if ($virtualMachine->encryptionRequired == true) {
            $data['encrypt'] = true;
        }

        if ($virtualMachine->backup == true) {
            $data['backup'] = true;
        }


        // support
        if ($virtualMachine->monitoring == true) {
            $data['monitoring'] = true;

            if (!empty($virtualMachine->monitoringContacts)) {
                $data['monitoring-contacts'] = $virtualMachine->monitoringContacts;
            }
        }


        $response = $this->post("v1/vms", json_encode($data), [
            'Content-Type' => 'application/json'
        ]);

        $body = $this->decodeJson($response->getBody()->getContents());

        $virtualMachine->id = $body->data->id;
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
    protected function loadEntity($item)
    {
        if (isset($item->hdd_disks) && is_array($item->hdd_disks)) {
            // hydrate HDD entities
            foreach ($item->hdd_disks as $key => $hdd) {
                $item->hdd_disks[$key] = new Hdd($this->apiToFriendly($hdd, static::HDD_MAP));
            };
        }

        // remap primary IP properties
        $item->ipAddresses = (object) [
            'internal' => isset($item->ip_internal) ? $item->ip_internal : null,
            'external' => isset($item->ip_external) ? $item->ip_external : null,
        ];
        unset($item->ip_internal, $item->ip_external);

        return new VirtualMachine($this->apiToFriendly($item, static::VM_MAP));
    }
}
