<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Backend;
use UKFast\SDK\Loadbalancers\Entities\CustomOption;
use UKFast\SDK\SelfResponse;

class BackendClient extends Client
{
    const MAP = [
        'cookie_opts' => 'cookieOpts',
        'timeouts_connect' => 'timeoutConnect',
        'timeouts_server' => 'timeoutServer',
    ];

    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all backends
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/backends', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeBackend($item);
        });
        return $page;
    }

    /**
     * Gets an individual backend
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Backend
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/backends/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeBackend($body->data);
    }

    /**
     * Creates a backend
     * @param \UKFast\SDK\Loadbalancers\Entities\Backend $backend
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($backend)
    {
        $response = $this->post('v2/backends', json_encode($this->friendlyToApi(
            $backend,
            self::MAP
        )));

        $response  = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeBackend($response->data);
            });
    }

    /**
     * @param object
     * @return \UKFast\SDK\Loadbalancers\Entities\Backend
     */
    protected function serializeBackend($raw)
    {
        return new Backend($this->apiToFriendly($raw, self::MAP));
    }
}
