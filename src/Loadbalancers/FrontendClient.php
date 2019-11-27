<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Frontend;
use UKFast\SDK\SelfResponse;

class FrontendClient extends Client
{
    const MAP = [
        'vips_id' => 'vipsId',
        'hsts_enabled' => 'hstsEnabled',
        'hsts_maxage' => 'hstsMaxAge',
        'redirect_https' => 'redirectHttps',
        'default_backend_id' => 'defaultBackendId',
    ];

    const SSL_MAP = [
        'binds_id' => 'bindsId',
        'allow_tlsv1' => 'allowTls_1_1',
        'allow_tlsv11' => 'allowTls_1_0',
        'disable_http2' => 'disableHttp2',
        'http2_only' => 'onlyHttp2'
    ];

    /**
     * Gets a paginated response of all Frontends
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/frontends', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Frontend($this->apiToFriendly($item, self::MAP));
        });

        return $page;
    }

    /**
     * Gets an individual frontend
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/frontends/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Frontend($this->apiToFriendly($body->data, self::MAP));
    }

    /**
     * Creates a new frontend
     * @param \UKFast\SDK\Loadbalancers\Entities\Frontend $frontend
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($frontend)
    {
        $json = json_encode($this->friendlyToApi($frontend, self::MAP));
        $response = $this->post("v2/frontends", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Frontend($this->apiToFriendly($response->data, self::MAP));
            });
    }

    public function addSsl($id, $ssl)
    {
        $json = json_encode($this->friendlyToApi($ssl, self::SSL_MAP));
        $response = $this->post("v2/frontends/$id/ssls", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Frontend($this->apiToFriendly($response->data, self::SSL_MAP));
            });
    }
}
