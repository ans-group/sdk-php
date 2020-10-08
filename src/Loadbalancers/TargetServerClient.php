<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\Target;
use UKFast\SDK\Loadbalancers\Entities\TargetServer;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;

class TargetServerClient extends Client implements ClientEntityInterface
{

    protected $basePath = 'loadbalancers/';

    use PageItems;

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'backend_id' => 'backendId',
            'ip' => 'ip',
            'port' => 'port',
            'weight' => 'weight',
            'backup' => 'backup',
            'check_interval' => 'checkInterval',
            'check_ssl' => 'checkSsl',
            'check_rise' => 'checkRise',
            'check_fall' => 'checkFall',
            'disable_http2' => 'disableHttp2',
            'http2_only' => 'http2Only',
            'send_proxy' => 'sendProxy',
            'send_proxy_v2' => 'sendProxyV2',
        ];
    }

    /**
     * Gets a page of Servers
     *
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->getEntityMap());
        $page = $this->paginatedRequest("v2/backends/$id/servers", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity((array) $item);
        });

        return $page;
    }

    /**
     * Get an server for a target by ID
     * @param $id
     * @param $serverId
     * @return TargetServer
     */
    public function getById($id, $serverId)
    {
        $response = $this->request("GET", "v2/backends/$id/servers/$serverId");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $id
     * @param $server
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($id, $server)
    {
        $json = json_encode($this->friendlyToApi($server, $this->getEntityMap()));

        $response = $this->post("v2/backends/$id/servers", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $id
     * @param $server
     * @return \UKFast\SDK\SelfResponse
     */
    public function update($id, $server)
    {
        $json = json_encode($this->friendlyToApi($server, $this->getEntityMap()));

        $response = $this->patch("v2/backends/$id/servers/{$server->id}", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $id
     * @param $serverId
     * @return bool
     */
    public function deleteById($id, $serverId)
    {
        $response = $this->delete("v2/backends/$id/servers/$serverId");

        return $response->getStatusCode() == 204;
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\TargetServer
     */
    public function loadEntity($data)
    {
        return new TargetServer($this->apiToFriendly($data, $this->getEntityMap()));
    }
}