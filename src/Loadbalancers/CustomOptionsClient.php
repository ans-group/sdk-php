<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\CustomOption;

class CustomOptionsClient extends Client
{
    /**
     * Gets a paginated response of all custom options
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/custom-options', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeCustomOption($item);
        });
        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\CustomOption
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/custom-options/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeCustomOption($body->data);
    }

    /**
     * Creates a custom option
     * @param \UKFast\SDK\Loadbalancers\Entities\CustomOption $customOption
     * @return \UKFast\SDK\SelfResponse
     */ 
    public function create($customOption)
    {
        $response = $this->post('v2/custom-options', json_encode($customOption->toArray([
            'frontendId' => 'frontend_id',
            'backendId' => 'backend_id',
            'backendServersId' => 'backend_servers_id',
        ])));

        $response  = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeCustomOption($response->data);
            });
    }

    protected function serializeCustomOption($raw)
    {
        return new CustomOption([
            'id' => $raw->id,
            'frontendId' => $raw->frontend_id,
            'backendId' => $raw->backend_id,
            'backendServersId' => $raw->backend_servers_id,
            'string' => $raw->string,
        ]);
    }
}