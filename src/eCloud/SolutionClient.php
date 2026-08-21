<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Datastore;
use UKFast\SDK\eCloud\Entities\Firewall;
use UKFast\SDK\eCloud\Entities\Host;
use UKFast\SDK\eCloud\Entities\Network;
use UKFast\SDK\eCloud\Entities\Site;
use UKFast\SDK\eCloud\Entities\Solution;
use UKFast\SDK\eCloud\Entities\Template;
use UKFast\SDK\eCloud\Entities\VirtualMachine;

class SolutionClient extends Client
{
    /**
     * Gets a paginated response of all Solutions
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Solution>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/solutions/$id");
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
     * @return Page<VirtualMachine>
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @return Page<Template>
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTemplateByName($id, $name)
    {
        $response = $this->get("v1/solutions/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Template($body->data);
    }

    /**
     * Gets a paginated response of a Solutions Hosts
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Host>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHosts($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/hosts", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Host($item);
        });

        return $page;
    }


    /**
     * Gets a paginated response of a Solutions Datastores
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Datastore>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDatastores($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/datastores", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Datastore(
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'status' => $item->status,
                    'capacity' => $item->capacity,
                    'allocated' => $item->allocated,
                    'available' => $item->available,
                    'solutionId' => $item->solution_id,
                    'siteId' => $item->site_id
                ]
            );
        });

        return $page;
    }

    /**
     * Gets a paginated response of a Solutions Sites
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Site>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSites($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/sites", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Site($item);
        });

        return $page;
    }

    /**
     * Gets a paginated response of a Solutions Networks
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Network>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNetworks($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/networks", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Network($item);
        });

        return $page;
    }

    /**
     * Gets a paginated response of a Solutions Firewalls
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page<Firewall>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFirewalls($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$id/firewalls", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Firewall($item);
        });

        return $page;
    }
}
