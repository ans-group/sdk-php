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
            return $this->serializeSsl($item);
        });

        return $page;
    }

    /**
     * Gets the SSL by its Id
     * @param int $sslId
     * @return object Ssl
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($sslId)
    {
        $response = $this->request("GET", "v1/ssls/$sslId");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeSsl($body->data);
    }

    /**
     * Send the request to the API to store a new job
     * @param Ssl $ssl
     * @return SelfResponse
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
                return $this->serializeSsl($body->data);
            });
    }

    /**
     * Converts a response stdClass into a Ssl entity
     *
     * @param $item
     * @return Ssl
     */
    protected function serializeSsl($item)
    {
        return new Ssl($this->apiToFriendly($item, self::CERTIFICATE_MAP));
    }
}
