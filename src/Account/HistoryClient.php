<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\History;
use UKFast\SDK\Client as BaseClient;

class HistoryClient extends BaseClient
{
    const MAP = [
        'id'         => 'id',
        'contact_id' => 'contactId',
        'username'   => 'username',
        'date'       => 'date',
        'ip'         => 'ip',
        'url'        => 'url',
        'user_agent' => 'userAgent'
    ];

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
        $filters = $this->friendlyToApi($filters, static::MAP);

        $page = $this->paginatedRequest("v1/history", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new History($this->apiToFriendly($item, static::MAP));
        });

        return $page;
    }
}
