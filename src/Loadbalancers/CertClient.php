<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Cert;

class CertClient extends BaseClient
{
    protected $basePath = 'loadbalancers/';

    const MAP = [
        'listener_id' => 'listenerId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'expires_at' => 'expiresAt',
        'ca_bundle' => 'caBundle',
    ];

    /**
     * Gets a paginated response of all Certs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/certs', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeCert($item);
        });

        return $page;
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\Cert
     */
    public function serializeCert($raw)
    {
        return new Cert($this->apiToFriendly($raw, self::MAP));
    }
}
