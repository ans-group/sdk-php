<?php

namespace UKFast\SDK\LTaaS;

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

    public function getDomain($domainId)
    {
        $response = $this->get('v1/domains/' . $domainId);

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Send the request to the API to store a new domain
     * @param $name
     * @param $verificationMethod
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store($name, $verificationMethod)
    {
        $data = [
            'name' => $name,
            'verification_method' => $verificationMethod
        ];

        $response = $this->post('v1/domains', json_encode($data));

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Verifiy the domain
     * @param $verificationMethod
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verify($verificationMethod, $id)
    {
        switch ($verificationMethod) {
            case 'DNS':
                $response = $this->post('v1/domains/' . $id . '/verify-by-dns');
                break;
            case 'File upload':
                $response = $this->post('v1/domains/' . $id . '/verify-by-file');
                break;
        }

        return $response->getStatusCode() == 200;
    }

    /**
     * Soft delete a domain
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete('v1/domains/' . $id);
        return $response->getStatusCode() == 204;
    }
}
