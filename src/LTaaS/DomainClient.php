<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Domain;

class DomainClient extends Client
{
    protected $basePath = 'load-tessting/';

    /**
     * Gets paginated response for all of the domains
     * @param int $page
     * @param int $perPage
     * @param array $filters
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Domain($item);
        });
    }
}