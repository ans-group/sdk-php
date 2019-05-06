<?php

namespace UKFast\eCloud;

use UKFast\Client as BaseClient;
use UKFast\Page;
use stdClass;

class Client extends BaseClient
{
    protected $basePath = 'ecloud/';


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
        $page = $this->paginatedRequest('v1/vms', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVirtualMachine($item);
        });

        return $page;
    }

    /**
     * Gets an individual Virtual Machine
     *
     * @param int $id
     * @return VirtualMachine
     */
    public function getVirtualMachine($id)
    {
        $response = $this->request("GET", "v1/vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeVirtualMachine($body->data);
    }

    /**
     * Converts a response stdClass into a VirtualMachine object
     *
     * @param stdClass
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
            $virtualMachine->disks = array_map(function ($item) {
                return $this->serializeHdd($item);
            }, $item->hdd_disks);
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

    /**
     * Converts a response stdClass into a Hdd object
     *
     * @param stdClass
     * @return Hdd
     */
    protected function serializeHdd($item)
    {
        $hdd = new Hdd;
        $hdd->name = $item->name;
        $hdd->capacity = $item->capacity;

        if (isset($item->uuid)) {
            $hdd->uuid = $item->uuid;
        }

        return $hdd;
    }


    /**
     * Gets a paginated response of all Solutions
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getSolutions($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/solutions', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeSolution($item);
        });

        return $page;
    }

    /**
     * Gets an individual Solution
     *
     * @param int $id
     * @return Solution
     */
    public function getSolution($id)
    {
        $response = $this->request("GET", "v1/solutions/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeSolution($body->data);
    }

    /**
     * Converts a response stdClass into a Solution object
     *
     * @param stdClass
     * @return Solution
     */
    protected function serializeSolution($item)
    {
        $solution = new Solution;

        $solution->id = $item->id;
        $solution->name = $item->name;

        $solution->environment = $item->environment;
        $solution->podId = $item->pod_id;

        return $solution;
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
    public function getSolutionVirtualMachines($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/vms", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVirtualMachine($item);
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
    public function getSolutionTemplates($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/templates", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeTemplate($item);
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
    public function getSolutionTemplate($id, $name)
    {
        $response = $this->request("GET", "v1/solutions/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeTemplate($body->data);
    }

    /**
     * Converts a response stdClass into a Template object
     *
     * @param stdClass
     * @return Template
     */
    protected function serializeTemplate($item)
    {
        $template = new Template;
        $template->name = $item->name;

        $template->cpu = $item->cpu;
        $template->ram = $item->ram;

        $template->hdd = $item->hdd;
        $template->disks = array_map(function ($item) {
            return $this->serializeHdd($item);
        }, $item->hdd_disks);
        $template->encrypted = $item->encrypted;

        $template->platform = $item->platform;

        return $template;
    }

    /**
     * Gets a paginated response of Hosts
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getHosts($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/hosts", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeHost($item);
        });

        return $page;
    }

    /**
     * Gets an individual Host
     *
     * @param int $id
     * @return Host
     */
    public function getHost($id)
    {
        $response = $this->request("GET", "v1/hosts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeHost($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Hosts
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getSolutionHosts($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/hosts", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeHost($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Datastore object
     *
     * @param stdClass
     * @return Host
     */
    protected function serializeHost($item)
    {
        $host = new Host;
        $host->id = $item->id;
        $host->name = $item->name;

        $host->cpu = $item->cpu;
        $host->ram = $item->ram;

        $host->solutionId = $item->solution_id;
        $host->podId = $item->pod_id;

        return $host;
    }

    /**
     * Gets a paginated response of Datastores
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getDatastores($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeDatastore($item);
        });

        return $page;
    }

    /**
     * Gets an individual Datastore
     *
     * @param int $id
     * @return Datastore
     */
    public function getDatastore($id)
    {
        $response = $this->request("GET", "v1/datastores/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeDatastore($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Datastores
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getSolutionDatastores($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVirtualMachine($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Datastore object
     *
     * @param stdClass
     * @return Datastore
     */
    protected function serializeDatastore($item)
    {
        $datastore = new Datastore;
        $datastore->id = $item->id;
        $datastore->name = $item->name;
        $datastore->status = $item->status;

        $datastore->capacity = $item->capacity;
        $datastore->allocated = $item->allocated;
        $datastore->available = $item->available;

        $datastore->solutionId = $item->solution_id;
        $datastore->siteId = $item->site_id;

        return $datastore;
    }

    /**
     * Gets a paginated response of Datastores
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getFirewalls($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/firewalls", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeFirewall($item);
        });

        return $page;
    }

    /**
     * Gets an individual Firewall
     *
     * @param int $id
     * @return Firewall
     */
    public function getFirewall($id)
    {
        $response = $this->request("GET", "v1/firewalls/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeFirewall($body->data);
    }

    /**
     * Gets an individual Firewalls config
     *
     * @param int $id
     * @return string
     */
    public function getFirewallConfig($id)
    {
        $response = $this->request("GET", "v1/firewalls/$id/config");
        $body = $this->decodeJson($response->getBody()->getContents());
        return base64_decode($body->data->config);
    }

    /**
     * Converts a response stdClass into a Firewall object
     *
     * @param stdClass
     * @return Firewall
     */
    protected function serializeFirewall($item)
    {
        $firewall = new Firewall;
        $firewall->id = $item->id;
        $firewall->name = $item->name;

        return $firewall;
    }

    /**
     * Gets a paginated response of Sites
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getSites($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/sites", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeDatastore($item);
        });

        return $page;
    }

    /**
     * Gets an individual Site
     *
     * @param int $id
     * @return Site
     */
    public function getSite($id)
    {
        $response = $this->request("GET", "v1/sites/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeSite($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Sites
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getSolutionSites($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/sites", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeSite($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Site object
     *
     * @param stdClass
     * @return Site
     */
    protected function serializeSite($item)
    {
        $site = new Site;
        $site->id = $item->id;
        $site->state = $item->state;

        $site->solutionId = $item->solution_id;
        $site->podId = $item->pod_id;

        return $site;
    }

    /**
     * Gets a paginated response of Pods
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getPods($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/pods", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializePod($item);
        });

        return $page;
    }

    /**
     * Gets an individual Pod
     *
     * @param int $id
     * @return Pod
     */
    public function getPod($id)
    {
        $response = $this->request("GET", "v1/pods/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializePod($body->data);
    }

    /**
     * Converts a response stdClass into a Pod object
     *
     * @param stdClass
     * @return Pod
     */
    protected function serializePod($item)
    {
        $pod = new Pod;
        $pod->id = $item->id;
        $pod->name = $item->name;

        $pod->services = (object) [
            'public' => $item->services->public,
            'burst' => $item->services->burst,
            'appliances' => $item->services->appliances,
        ];

        return $pod;
    }
}
