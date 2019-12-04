<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Entity;
use UKFast\SDK\Loadbalancers\Entities\Access;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Loadbalancers\Entities\Cert;
use UKFast\SDK\Loadbalancers\Entities\Frontend;
use UKFast\SDK\Loadbalancers\Entities\Ssl;
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
        'disable_http2' => 'disableHttp2',
        'http2_only' => 'onlyHttp2',
        'custom_ciphers' => 'customCiphers',
        'custom_tls13_ciphers' => 'customTls13Ciphers',
    ];

    const BIND_MAP = [
        'frontend_id' => 'frontendId',
        'vips_id' => 'vipsId',
    ];

    const CERT_MAP = [
        'frontend_id' => 'frontendId',
        'certs_name' => 'name',
        'certs_pem' => 'pem',
    ];

    const ACCESS_MAP = [
        'frontend_id' => 'frontendId',
    ];

    protected $basePath = 'loadbalancers/';

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
     * Gets a page of Ssls
     *
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getSsls($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->sslToApiFormat($filters, self::SSL_MAP);
        $page = $this->paginatedRequest("v2/frontends/$id/ssls", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->apiFormatToSsl((array) $item);
        });

        return $page;
    }

    /**
     * Gets a page of Binds
     *
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getBinds($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::BIND_MAP);
        $page = $this->paginatedRequest("v2/frontends/$id/binds", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Bind($this->apiToFriendly($item, self::BIND_MAP));
        });

        return $page;
    }
    
    /**
     * Gets a page of Certs
     *
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getCerts($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::CERT_MAP);
        $page = $this->paginatedRequest("v2/frontends/$id/certs", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Cert($this->apiToFriendly($item, self::CERT_MAP));
        });

        return $page;
    }

    /**
     * Gets a page of Access
     *
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getAccess($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::ACCESS_MAP);
        $page = $this->paginatedRequest("v2/frontends/$id/access", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Access($this->apiToFriendly($item, self::ACCESS_MAP));
        });

        return $page;
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

    /**
     * Creates a new SSL
     * @param \UKFast\SDK\Loadbalancers\Entities\Ssl $ssl
     * @return \UKFast\SDK\SelfResponse
     */
    public function addSsl($id, $ssl)
    {
        $json = json_encode($this->friendlyToApi($this->sslToApiFormat($ssl), self::SSL_MAP));

        $response = $this->post("v2/frontends/$id/ssls", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->apiFormatToSsl((array) $response->data);
            });
    }

    /**
     * Creates a new Binding
     * @param \UKFast\SDK\Loadbalancers\Entities\Bind $ssl
     * @return \UKFast\SDK\SelfResponse
     */
    public function addBind($id, $bind)
    {
        $json = json_encode($this->friendlyToApi($bind, self::BIND_MAP));
        $response = $this->post("v2/frontends/$id/binds", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Bind($this->apiToFriendly($response->data, self::BIND_MAP));
            });
    }

    /**
     * Creates a new Access
     * @param \UKFast\SDK\Loadbalancers\Entities\Access $acess
     * @return \UKFast\SDK\SelfResponse
     */
    public function addAccess($id)
    {
        $response = $this->post("v2/frontends/$id/access", null);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Access($this->apiToFriendly($response->data, self::ACCESS_MAP));
            });
    }

    protected function sslToApiFormat($ssl)
    {
        $apiFormat = $ssl;
        if ($ssl instanceof Entity) {
            $apiFormat = $ssl->toArray();
        }

        if (isset($apiFormat['allowTls'])) {
            $apiFormat['allow_tlsv1'] = in_array('1.0', $ssl->allowTls);
            $apiFormat['allow_tlsv11'] = in_array('1.1', $ssl->allowTls);
            unset($apiFormat['allowTls']);
        }

        return $apiFormat;
    }

    protected function apiFormatToSsl($apiFormat)
    {
        $allowTls = [];
        if ($apiFormat['allow_tlsv1']) {
            $allowTls[] = '1.0';
        }

        if ($apiFormat['allow_tlsv11']) {
            $allowTls[] = '1.1';
        }

        unset($apiFormat['allow_tlsv11']);
        unset($apiFormat['allow_tlsv1']);

        $ssl = new Ssl($this->apiToFriendly($apiFormat, self::SSL_MAP));
        $ssl->allowTls = $allowTls;
        return $ssl;
    }
}
