<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Domain;

class DomainClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Gets paginated response for all of the domains
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws GuzzleException
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
     * Send the request to the API to store a new domain
     * @param Domain $domain
     * @return mixed
     * @throws GuzzleException
     */
    public function store(Domain $domain)
    {
        $data = [
            'name' => $domain->name
        ];

        $response = $this->post('v1/domains', json_encode($data));

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Retrieve a domain by ID
     * @param $domainId
     * @return Domain
     * @throws GuzzleException
     */
    public function getById($domainId)
    {
        $response = $this->get('v1/domains/' . $domainId);

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Verifiy the domain
     * @param $domainId
     * @param $verificationMethod
     * @return mixed
     * @throws GuzzleException
     */
    public function verify($domainId, $verificationMethod)
    {
        switch ($verificationMethod) {
            case 'DNS':
                $response = $this->post('v1/domains/' . $domainId . '/verify-by-dns');
                break;
            case 'File upload':
                $response = $this->post('v1/domains/' . $domainId . '/verify-by-file');
                break;
        }

        return $response->getStatusCode() == 200;
    }

    /**
     * Soft delete a domain
     * @param $id
     * @return bool
     * @throws GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete('v1/domains/' . $id);
        return $response->getStatusCode() == 204;
    }
}
