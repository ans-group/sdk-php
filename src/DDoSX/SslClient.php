<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Ssl;
use UKFast\SDK\SelfResponse;

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

    /**
     * Send the request to the API to store a new job
     * @param Ssl $ssl
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Ssl $ssl)
    {
        $data     = $this->friendlyToApi($ssl, static::CERTIFICATE_MAP);
        $response = $this->post('v1/ssls', json_encode($data));
        $body     = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Ssl($this->apiToFriendly($body->data, self::CERTIFICATE_MAP));
            });
    }
}
