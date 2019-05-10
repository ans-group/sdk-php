<?php

namespace UKFast\PHaaS;

use Exception;
use Psr\Http\Message\ResponseInterface;
use UKFast\Exception\ApiException;
use UKFast\Exception\ValidationException;
use UKFast\Page;
use UKFast\Client as BaseClient;

class GroupClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getGroups($page = 1, $perPage = 15, $filters = [])
    {
        $groups = $this->paginatedRequest('v1/groups', $page, $perPage, $filters);

        $groups->serializeWith(function ($item) {
            return $this->serializeGroup($item);
        });

        return $groups;
    }

    /**
     * @param $item
     * @return Group
     */
    protected function serializeGroup($item)
    {
        return new Group($item);
    }
}
