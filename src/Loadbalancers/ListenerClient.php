<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Loadbalancers\Entities\Cert;
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
    ];

    const BIND_MAP = [
        'frontend_id' => 'frontendId',
        'vip_id' => 'vipId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    const CERT_MAP = [
        'frontend_id' => 'frontendId',
        'ca_bundle' => 'caBundle'
    ];

    protected $collectionPath = 'v2/listeners';

    public function getEntityMap()
    {
        return static::MAP;
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
            json_encode($this->friendlyToApi($bind, self::BIND_MAP))
        );
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Bind($this->apiToFriendly($response->data, self::BIND_MAP));
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
        return new Listener($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
