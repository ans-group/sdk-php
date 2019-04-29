<?php

namespace UKFast\eCloud;

use UKFast\Client as BaseClient;
use UKFast\Page;

class Client extends BaseClient
{
    protected $basePath = 'ecloud/v1/';

    /**
     * Gets a paginated response of all Virtual Machines
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getVirtualMachines($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('vms', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVirtualMachine($item);
        });

        return $page;
    }

    /**
     * Gets an individual Virtual Machine
     *
     * @param int $id
     * @return \UKFast\eCloud\VirtualMachine
     */
    public function getVirtualMachine($id)
    {
        $response = $this->request("GET", "vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeVirtualMachine($body->data);
    }


    /**
     * Converts a response stdClass into a Request object
     *
     * @param \stdClass
     * @return VirtualMachine
     */
    protected function serializeVirtualMachine($item)
    {
        $virtualMachine = new VirtualMachine;

        $virtualMachine->id = $item->id;
        $virtualMachine->name = $item->name;

        $virtualMachine->computerName = $item->computername;
        $virtualMachine->hostname = $item->hostname;

        $virtualMachine->cpu = $item->cpu;
        $virtualMachine->ram = $item->ram;
        $virtualMachine->hdd = $item->hdd;

        if (isset($item->hdd_disks)) {
            $virtualMachine->disks = $item->hdd_disks;
        }

        $virtualMachine->ip_addresses = (object) [
            'internal' => $item->ip_internal,
            'external' => $item->ip_external,
        ];

        $virtualMachine->template = $item->template;
        $virtualMachine->platform = $item->platform;

        $virtualMachine->backup = $item->backup;
        $virtualMachine->support = $item->support;

        $virtualMachine->environment = $item->environment;
        $virtualMachine->solutionId = $item->solution_id;

        $virtualMachine->status = $item->status;

        if (isset($item->power_status)) {
            $virtualMachine->power = $item->power_status;
        }

        if (isset($item->power_status)) {
            $virtualMachine->tools = $item->tools_status;
        }

        return $virtualMachine;
    }
}
