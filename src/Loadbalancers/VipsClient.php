<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Vip;

class VipsClient extends Client
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
        $page = $this->paginatedRequest('v2/vips', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVip($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/vips/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeVip($body->data);
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function serializeVip($raw)
    {
        return new Vip([
            'id' => $raw->id,
            'groupId' => $raw->group_id,
            'type' => $raw->type,
            'cidr' => $raw->cidr,
        ]);
    }
}
