<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Firewall;

class FirewallClient extends Client
{
    /**
     * Gets a paginated response of Firewalls
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
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
    public function getById($id)
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
    public function getConfigById($id)
    {
        $response = $this->request("GET", "v1/firewalls/$id/config");
        $body = $this->decodeJson($response->getBody()->getContents());
        return base64_decode($body->data->config);
    }
}
