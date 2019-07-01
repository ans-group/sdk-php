<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Firewall;

class FirewallClient extends Client
{
    /**
     * Gets a paginated response of Firewalls
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get("v1/firewalls/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Firewall($body->data);
    }

    /**
     * Gets an individual Firewalls config
     *
     * @param int $id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConfigById($id)
    {
        $response = $this->get("v1/firewalls/$id/config");
        $body = $this->decodeJson($response->getBody()->getContents());
        return base64_decode($body->data->config);
    }
}
