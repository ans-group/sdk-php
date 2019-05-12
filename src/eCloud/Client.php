<?php

namespace UKFast\eCloud;

use UKFast\Client as BaseClient;
use UKFast\Page;

use UKFast\eCloud\Entities\Datastore;
use UKFast\eCloud\Entities\Firewall;
use UKFast\eCloud\Entities\Host;
use UKFast\eCloud\Entities\Pod;
use UKFast\eCloud\Entities\Site;
use UKFast\eCloud\Entities\Solution;
use UKFast\eCloud\Entities\Template;
use UKFast\eCloud\Entities\VirtualMachine;

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
    public function getVirtualMachine($id)
    {
        $response = $this->request("GET", "v1/vms/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new VirtualMachine($body->data);
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
    public function getSolution($id)
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
    public function getSolutionVirtualMachines($id, $page = 1, $perPage = 15, $filters = [])
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
    public function getSolutionTemplates($id, $page = 1, $perPage = 15, $filters = [])
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
    public function getSolutionTemplate($id, $name)
    {
        $response = $this->request("GET", "v1/solutions/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Template($body->data);
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
            return new Host($item);
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
        return new Host($body->data);
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
            return new Host($item);
        });

        return $page;
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
            return new Datastore($item);
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
        return new Datastore($body->data);
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
            return new Datastore($item);
        });

        return $page;
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
            return new Firewall($item);
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
        return new Firewall($body->data);
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
            return new Site($item);
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
        return new Site($body->data);
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
            return new Site($item);
        });

        return $page;
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
            return new Pod($item);
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
        return new Pod($body->data);
    }
}
