<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Backend;
use UKFast\SDK\Loadbalancers\Entities\CustomOption;
use UKFast\SDK\SelfResponse;

class BackendClient extends Client
{
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
        $response = $this->post('v2/backends', json_encode($backend->toArray([
            'cookieOpts' => 'cookie_opts',
            'timeoutConnect' => 'timeouts_connect',
            'timeoutServer' => 'timeouts_server',
        ])));

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
        return new Backend([
            'id' => $raw->id,
            'name' => $raw->name,
            'balance' => $raw->balance,
            'mode' => $raw->mode,
            'close' => $raw->close,
            'sticky' => $raw->sticky,
            'cookieOpts' => $raw->cookie_opts,
            'timeoutConnect' => $raw->timeouts_connect,
            'source' => $raw->source,
            'timeoutServer' => $raw->timeouts_server,
        ]);
    }
}