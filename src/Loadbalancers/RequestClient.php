<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Request;

class RequestClient extends Client
{
    /**
     * Gets a paginated response of all requests
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/requests', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeRequest($item);
        });
        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/requests/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeRequest($body->data);
    }

    /**
     * Creates a request
     * @param \UKFast\SDK\Loadbalancers\Entities\Request $request
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($request)
    {
        $response = $this->post('v2/requests', json_encode($request->toArray([
            'haProxyConfig' => 'haproxy_cfg',
            'configId' => 'config_id',
        ])));

        $response  = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeRequest($response->data);
            });
    }

    /**
     * @param object $raw
     * @return \UKFast\SDK\Loadbalancers\Entities\Request
     */
    protected function serializeRequest($raw)
    {
        return new Request([
            'id' => $raw->id,
            'haProxyConfig' => $raw->haproxy_cfg,
        ]);
    }
}