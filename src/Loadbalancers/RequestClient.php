<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Request;
use UKFast\SDK\SelfResponse;

class RequestClient extends Client
{
    const MAP = [
        'haproxy_cfg' => 'haProxyConfig',
        'config_id' => 'configId',
    ];
    
    protected $basePath = 'loadbalancers/';

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
        $filters = $this->friendlyToApi($filters, self::MAP);
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
        $response = $this->post('v2/requests', json_encode($this->friendlyToApi(
            $request,
            self::MAP
        )));

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
        return new Request($this->apiToFriendly($raw, self::MAP));
    }
}
