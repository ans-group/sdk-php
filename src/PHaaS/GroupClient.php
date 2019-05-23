<?php

namespace UKFast\PHaaS;

use UKFast\Page;
use UKFast\Client as BaseClient;
use UKFast\PHaaS\Entities\Group;

class GroupClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getAll($page = 1, $perPage = 15, $filters = [])
    {
        $groups = $this->paginatedRequest('v1/groups', $page, $perPage, $filters);

        $groups->serializeWith(function ($item) {
            return new Group($item);
        });

        return $groups;
    }
}
