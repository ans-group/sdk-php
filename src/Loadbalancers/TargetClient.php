<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\Target;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;

class TargetClient extends BaseClient implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/targets';

    public function getEntityMap()
    {
        return [
            'target_group_id' => 'targetGroupId',
            'check_interval' => 'checkInterval',
            'check_ssl' => 'checkSsl',
            'check_rise' => 'checkRise',
            'check_fall' => 'checkFall',
            'disable_http2' => 'disableHttp2',
            'http2_only' => 'http2Only',
            'session_cookie_value' => 'sessionCookieValue',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    /**
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
        $page = $this->paginatedRequest("v2/target-groups/$groupId/targets", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity((array) $item);
        });

        return $page;
    }

    /**
     * @param $groupId
     * @param $targetId
     * @return Target
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTargetByGroupId($groupId, $targetId)
    {
        $response = $this->request("GET", "v2/target-groups/$groupId/targets/$targetId");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $groupId
     * @param $target
     * @return \UKFast\SDK\SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createTargetByGroupId($groupId, $target)
    {
        $json = json_encode($this->friendlyToApi($target, $this->getEntityMap()));

        $response = $this->post("v2/target-groups/$groupId/targets", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $groupId
     * @param $target
     * @return \UKFast\SDK\SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateTargetByGroupId($groupId, $target)
    {
        $json = json_encode($this->friendlyToApi($target, $this->getEntityMap()));

        $response = $this->patch("v2/target-groups/$groupId/targets/{$target->id}", $json);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->loadEntity((array) $response->data);
            });
    }

    /**
     * @param $groupId
     * @param $targetId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteTargetByGroupId($groupId, $targetId)
    {
        $response = $this->delete("v2/target-groups/$groupId/targets/$targetId");

        return $response->getStatusCode() == 204;
    }

    /**
     * @param $data
     * @return \UKFast\SDK\Loadbalancers\Entities\Target
     */
    public function loadEntity($data)
    {
        return new Target($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
