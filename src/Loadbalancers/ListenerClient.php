<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\AccessRule;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Loadbalancers\Entities\Cert;
use UKFast\SDK\Loadbalancers\Entities\Listener;
use UKFast\SDK\Loadbalancers\Entities\Ssl;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;

class ListenerClient extends BaseClient implements ClientEntityInterface
{
    use PageItems;

    const MAP = [
        'cluster_id' => 'clusterId',
        'hsts_enabled' => 'hstsEnabled',
        'hsts_maxage' => 'hstsMaxage',
        'redirect_https' => 'redirectHttps',
        'default_target_group_id' => 'defaultTargetGroupId',
    ];

    const SSL_MAP = [
        'binds_id' => 'bindsId',
        'allow_tls_v1' => 'allowTlsV1',
        'allow_tls_v11' => 'allowTlsV11',
        'disable_http2' => 'disableHttp2',
        'http2_only' => 'http2Only',
        'custom_ciphers' => 'customCiphers',
        'custom_tls13_ciphers' => 'customTls13Ciphers',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    const BIND_MAP = [
        'frontend_id' => 'frontendId',
        'vips_id' => 'vipsId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    const CERT_MAP = [
        'frontend_id' => 'frontendId',
        'certs_name' => 'name',
        'cert_key' => 'key',
        'cert_certificate' => 'certificate',
        'cert_bundle' => 'bundle'
    ];

    const ACCESS_RULE_MAP = [
        'frontend_id' => 'frontendId',
        'whitelist' => 'whitelist',
    ];

    protected $collectionPath = 'v2/listeners';

    public function getEntityMap()
    {
        return static::MAP;
    }

    /**
     * Gets a page of SSLs
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
        $page = $this->paginatedRequest("v2/listeners/$id/ssls", $page, $perPage, $filters);
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
        $page = $this->paginatedRequest("v2/listeners/$id/binds", $page, $perPage, $filters);
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
    public function getCertsPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::CERT_MAP);
        $page = $this->paginatedRequest("v2/listeners/$id/certs", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Cert($this->apiToFriendly($item, self::CERT_MAP));
        });

        return $page;
    }

    /**
     * Get a Listener cert resource
     * @param $id
     * @param $certId
     * @return Cert
     */
    public function getCertsById($id, $certId)
    {
        $response = $this->request("GET", "v2/listeners/$id/certs/$certId");
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Cert($this->apiToFriendly($body->data, self::CERT_MAP));
    }


    /**
     * Gets a page of listener access rules
     *
     * @param int $id Listener ID
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getAccessRulePage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::ACCESS_RULE_MAP);
        $page = $this->paginatedRequest("v2/listeners/$id/access", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new AccessRule($this->apiToFriendly($item, self::ACCESS_RULE_MAP));
        });

        return $page;
    }

    /**
     * Get an access rule for a listener by ID
     * @param $id
     * @param $accessRuleId
     * @return AccessRule
     */
    public function getAccessRuleById($id, $accessRuleId)
    {
        $response = $this->request("GET", "v2/listeners/$id/access/$accessRuleId");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new AccessRule($this->apiToFriendly($body->data, self::ACCESS_RULE_MAP));
    }

    /**
     * Creates a new SSL
     * @param $id Listener ID
     * @param \UKFast\SDK\Loadbalancers\Entities\Ssl $ssl
     * @return \UKFast\SDK\SelfResponse
     */
    public function addSsl($id, $ssl)
    {
        $json = json_encode($this->friendlyToApi($this->sslToApiFormat($ssl), self::SSL_MAP));

        $response = $this->post("v2/listeners/$id/ssls", $json);
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
        $response = $this->post("v2/listeners/$id/binds", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Bind($this->apiToFriendly($response->data, self::BIND_MAP));
            });
    }

    /**
     * Creates a new listener access rule
     * @param $id Listener ID
     * @return \UKFast\SDK\SelfResponse
     */
    public function addAccessRule($id)
    {
        $response = $this->post("v2/listeners/$id/access", null);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new AccessRule($this->apiToFriendly($response->data, self::ACCESS_RULE_MAP));
            });
    }

    /**
     * @param $id
     * @param Cert $cert
     * @return SelfResponse
     */
    public function addCert($id, Cert $cert)
    {
        $response = $this->post(
            "v2/listeners/$id/certs",
            json_encode($this->friendlyToApi($cert, self::CERT_MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Cert($this->apiToFriendly($response->data, self::CERT_MAP));
            });
    }

    /**
     * Update access rule for a listener
     * @param $id
     * @param AccessRule $accessRule
     * @return SelfResponse
     */
    public function updateAccessRule($id, AccessRule $accessRule)
    {
        $response = $this->patch(
            "v2/listeners/$id/access/$accessRule->id",
            json_encode($this->friendlyToApi($accessRule, self::ACCESS_RULE_MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new AccessRule($this->apiToFriendly($response->data, self::ACCESS_RULE_MAP));
            });
    }

    public function updateCert($id, Cert $cert)
    {
        $response = $this->patch(
            "v2/listeners/$id/certs/$cert->id",
            json_encode($this->friendlyToApi($cert, self::CERT_MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Cert($this->apiToFriendly($response->data, self::CERT_MAP));
            });
    }

    /**
     * @param $id
     * @param string $accessRuleId
     * @return bool
     */
    public function deleteAccessRule($id, $accessRuleId)
    {
        $response = $this->delete("v2/listeners/$id/access/$accessRuleId");

        return $response->getStatusCode() == 204;
    }

    /**
     * Remove a cert from the listener
     * @param $id
     * @param $certId
     * @return bool
     */
    public function deleteCertById($id, $certId)
    {
        $response = $this->delete("v2/listeners/$id/certs/$certId");

        return $response->getStatusCode() == 204;
    }

    /**
     * Remove a bind from the listener
     * @param $id
     * @param $bindId
     * @return bool
     */
    public function deleteBindById($id, $bindId)
    {
        $response = $this->delete("v2/listeners/$id/binds/$bindId");

        return $response->getStatusCode() == 204;
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

    /**
     * @param $data
     * @return Listener
     */
    public function loadEntity($data)
    {
        return new Listener($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
