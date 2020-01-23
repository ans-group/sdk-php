<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Ssl;

class SslClient extends BaseClient
{
    /**
     * The API's basepath
     *
     * @var string $basepath
     */
    protected $basePath = 'ddosx/';

    const CERTIFICATE_MAP = [
        'ukfast_ssl_id' => 'ukfastSslId',
        'friendly_name' => 'friendlyName',
        'expires_at'    => 'expiresAt',
    ];

    /**
     * Gets a paginated list of SSLs
     *
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::CERTIFICATE_MAP);
        $page    = $this->paginatedRequest('v1/ssls', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new Ssl($this->apiToFriendly($item, self::CERTIFICATE_MAP));
        });

        return $page;
    }
}
