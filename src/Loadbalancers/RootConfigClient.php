<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Configuration;

class RootConfigClient extends Client
{
    /**
     * Gets a paginated response of all ACLs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/configurations', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeConfiguration($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/configurations/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeConfiguration($body->data);
    }

    protected function serializeConfiguration($raw)
    {
        return new Configuration([
            'id' => $raw->id,
            'groupId' => $raw->group_id,
            'requestId' => $raw->request_id,
        ]);
    }
}