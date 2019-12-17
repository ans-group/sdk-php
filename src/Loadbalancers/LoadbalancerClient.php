<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Loadbalancer;

class LoadbalancerClient extends BaseClient
{
    const MAP = [];

    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all loadbalancers
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/loadbalancers', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Loadbalancer($this->apiToFriendly($item, self::MAP));
        });
        return $page;
    }
}
