<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Loadbalancers\Entities\AccessIp;

class AccessIpClient extends BaseClient
{
    protected $basePath = 'loadbalancers/';

    const MAP = [
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    /**
     * @param int $listenerId
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($listenerId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v2/listeners/$listenerId/access-ips", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new AccessIp($this->apiToFriendly($item, static::MAP));
        });

        return $page;
    }

    /**
     * @param int $accessIpId
     * @return AccessIp
     */
    public function getById($accessIpId)
    {
        $response = $this->get("v2/access-ips/$accessIpId");
        $body = $this->decodeJson($response->getBody()->getContents());

        return new AccessIp($this->apiToFriendly($body->data, static::MAP));
    }

    /**
     * @param int $listenerId
     * @param AccessIp $accessIp
     * @return SelfResponse
     */
    public function create($listenerId, AccessIp $accessIp)
    {
        $data = json_encode($this->friendlyToApi($accessIp, static::MAP));
        $response = $this->post("v2/listeners/$listenerId/access-ips", $data);
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new AccessIp($this->apiToFriendly($body->data, static::MAP));
            });
    }

    /**
     * @param Record $record
     * @return SelfResponse
     */
    public function update(AccessIp $accessIp)
    {
        $data = json_encode($this->friendlyToApi($accessIp, static::MAP));
        $response = $this->patch("v2/access-ips/{$accessIp->id}", $data);
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new AccessIp($this->apiToFriendly($body->data, $this->requestMap));
            });
    }


    /**
     * @param AccessIp $accessIp
     * @return bool
     */
    public function destroy(AccessIp $accessIp)
    {
        $response = $this->delete("v2/access-ips/{$accessIp->id}");

        return $response->getStatusCode() == 204;
    }
}
