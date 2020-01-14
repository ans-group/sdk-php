<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\History;
use UKFast\SDK\Client as BaseClient;

class HistoryClient extends BaseClient
{
    protected $basePath = 'account/';

    /**
     * Gets a paginated response of all history entries
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/history", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new History($item);
        });

        return $page;
    }
}
