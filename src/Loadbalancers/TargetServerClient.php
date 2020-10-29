<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\Target;
use UKFast\SDK\Loadbalancers\Entities\TargetServer;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;

class TargetServerClient extends BaseClient implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/target-servers';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'targetgroup_id' => 'targetgroupId',
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
     * Gets a page of Servers by group id
     *
     * @param int $groupId
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPageByGroupId($groupId, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->getEntityMap());
        $page = $this->paginatedRequest("v2/target-groups/$groupId/servers", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity((array) $item);
        });

        return $page;
    }

    /**
     * Get an server for a target by ID
     * @param $groupId
     * @param $serverId
     * @return TargetServer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServerByGroupId($groupId, $serverId)
    {
        $response = $this->request("GET", "v2/target-groups/$groupId/servers/$serverId");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $groupId
     * @param $server
     * @return \UKFast\SDK\SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createServerByGroupId($groupId, $server)
    {
        $json = json_encode($this->friendlyToApi($server, $this->getEntityMap()));

        $response = $this->post("v2/target-groups/$groupId/servers", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $groupId
     * @param $server
     * @return \UKFast\SDK\SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateServerByGroupId($groupId, $server)
    {
        $json = json_encode($this->friendlyToApi($server, $this->getEntityMap()));

        $response = $this->patch("v2/target-groups/$groupId/servers/{$server->id}", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $groupId
     * @param $serverId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteServerByGroupId($groupId, $serverId)
    {
        $response = $this->delete("v2/target-groups/$groupId/servers/$serverId");

        return $response->getStatusCode() == 204;
    }

    /**
     * @param $data
     * @return \UKFast\SDK\Loadbalancers\Entities\TargetServer
     */
    public function loadEntity($data)
    {
        return new TargetServer($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
