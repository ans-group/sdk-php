<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Loadbalancers\Entities\Cert;
use UKFast\SDK\Loadbalancers\Entities\GeoIp;
use UKFast\SDK\Loadbalancers\Entities\Listener;
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
        'access_is_allow_list' => 'accessIsAllowList',
        'allow_tlsv1' => 'allowTlsv1',
        'allow_tlsv11' => 'allowTlsv11',
        'disable_tlsv12' => 'disableTlsv12',
        'disable_http2' => 'disableHttp2',
        'http2_only' => 'http2Only',
        'custom_ciphers' => 'customCiphers',
        'custom_options' => 'customOptions',
        'timeouts_client' => 'timeoutsClient',
    ];

    const CERT_MAP = [
        'frontend_id' => 'frontendId',
        'ca_bundle' => 'caBundle',
        'expires_at' => 'expiresAt',
    ];


    const GEOIP_MAP = [
        'european_union' => 'europeanUnion'
    ];

    protected $collectionPath = 'v2/listeners';

    public function getEntityMap()
    {
        return static::MAP;
    }

    public function friendlyToApi($item, $map)
    {
        $raw = parent::friendlyToApi($item, $map);
        if (isset($item['geoip'])) {
            $rawGeoIp = $this->friendlyToApi($item['geoip'], self::GEOIP_MAP);
            $raw['geoip'] = $rawGeoIp;
        }

        return $raw;
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
        $filters = $this->friendlyToApi($filters, Bind::$entityMap);
        $page = $this->paginatedRequest("v2/listeners/$id/binds", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Bind($this->apiToFriendly($item, Bind::$entityMap));
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
     * Creates a new Binding
     * @param \UKFast\SDK\Loadbalancers\Entities\Bind $ssl
     * @return \UKFast\SDK\SelfResponse
     */
    public function addBind($id, $bind)
    {
        $json = json_encode($this->friendlyToApi($bind, Bind::$entityMap));
        $response = $this->post("v2/listeners/$id/binds", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Bind($this->apiToFriendly($response->data, Bind::$entityMap));
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
    
    public function updateBind($id, Bind $bind)
    {
        $response = $this->patch(
            "v2/listeners/$id/binds/{$bind->id}",
            json_encode($this->friendlyToApi($bind, Bind::$entityMap))
        );
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Bind($this->apiToFriendly($response->data, Bind::$entityMap));
            });
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

    /**
     * @param $data
     * @return Listener
     */
    public function loadEntity($data)
    {
        $listener = new Listener($this->apiToFriendly($data, self::MAP));
        if (isset($data->geoip)) {
            $listener->geoip = new GeoIp($this->apiToFriendly($data->geoip, self::GEOIP_MAP));
        }

        return $listener;
    }
}
