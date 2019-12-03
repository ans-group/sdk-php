<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Group;
use UKFast\SDK\SelfResponse;

class GroupClient extends Client
{
    const MAP = [];

    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all Groups
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/groups', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeGroup($item);
        });

        return $page;
    }

    /**
     * Gets an individual group
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/groups/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeGroup($body->data);
    }

    /**
     * Creates a group
     * @param \UKFast\SDK\Loadbalancers\Entities\Group $group
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($group)
    {
        $json = json_encode($this->friendlyToApi($group, self::MAP));
        $response = $this->post("v2/groups", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeGroup($response->data);
            });
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\Group
     */
    public function serializeGroup($raw)
    {
        return new Group($this->apiToFriendly($raw, self::MAP));
    }
}
