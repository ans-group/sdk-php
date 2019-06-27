<?php

namespace UKFast\Domains;

use UKFast\Client;
use UKFast\Page;
use UKFast\Domains\Entities\Domain;
use UKFast\Domains\Entities\Nameserver;

class DomainClient extends Client
{
    protected $basePath = 'registrar/';

    /**
     * Gets a paginated response of all Domains
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Domain($item);
        });

        return $page;
    }

    /**
     * Gets an individual Domain
     *
     * @param string $name
     * @return Domain
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByName($name)
    {
        $response = $this->request("GET", "v1/domains/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Domain($body->data);
    }

    /**
     * Gets an individual Domains Nameservers
     *
     * @param string $name
     * @return Domain
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNameserversByName($name)
    {
        $response = $this->request("GET", "v1/domains/$name/nameservers");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return new Nameserver($item);
        }, $body->data);
    }
}
