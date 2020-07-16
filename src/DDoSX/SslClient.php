<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Ssl;
use UKFast\SDK\DDoSX\Entities\SslCertificate;
use UKFast\SDK\DDoSX\Entities\SslPrivateKey;
use UKFast\SDK\SelfResponse;

class SslClient extends BaseClient
{
    /**
     * @var string $basepath
     */
    protected $basePath = 'ddosx/';

    const SSL_MAP = [
        'ukfast_ssl_id' => 'ukfastSslId',
        'friendly_name' => 'friendlyName',
        'expires_at'    => 'expiresAt',
    ];

    const CERTIFICATE_MAP = [
        'ca_bundle' => 'caBundle'
    ];

    const PRIVATE_KEY_MAP = [];

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
        $filters = $this->friendlyToApi($filters, self::SSL_MAP);
        $page    = $this->paginatedRequest('v1/ssls', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeSsl($item);
        });

        return $page;
    }

    /**
     * Gets the SSL by its identifier
     * @param string $sslId
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
        $data     = $this->friendlyToApi($ssl, static::SSL_MAP);
        $response = $this->post('v1/ssls', json_encode($data));
        $body     = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return $this->serializeSsl($body->data);
            });
    }

    /**
     * Get the certificate by its SSL identifier
     * @param $sslId
     * @return SslCertificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCertificate($sslId)
    {
        $response = $this->get('v1/ssls/' . $sslId . '/certificates');
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeCertificate($body);
    }

    /**
     * Get the private key by its SSL identifier
     * @param $sslId
     * @return SslPrivateKey
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrivateKey($sslId)
    {
        $response = $this->get('v1/ssls/' . $sslId . '/private-key');
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializePrivateKey($body);
    }

    /**
     * Delete an existing DDoSX SSL
     *
     * @param Ssl $ssl
     * @return bool
     */
    public function destroy(Ssl $ssl)
    {
        $response = $this->delete("v1/ssls/{$ssl->id}");
        return $response->getStatusCode() == 204;
    }

    /**
     * @param $raw
     * @return Ssl
     */
    protected function serializeSsl($raw)
    {
        return new Ssl($this->apiToFriendly($raw, self::SSL_MAP));
    }

    /**
     * @param $raw
     * @return SslCertificate
     */
    protected function serializeCertificate($raw)
    {
        return new SslCertificate($this->apiToFriendly($raw, self::CERTIFICATE_MAP));
    }

    /**
     * @param $raw
     * @return SslPrivateKey
     */
    protected function serializePrivateKey($raw)
    {
        return new SslPrivateKey($this->apiToFriendly($raw, self::PRIVATE_KEY_MAP));
    }
}
