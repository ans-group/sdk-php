<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client;
use UKFast\SDK\Page;
use UKFast\SDK\SSL\Entities\Certificate;
use UKFast\SDK\SSL\Entities\CertificatePEM;
use UKFast\SDK\SSL\Entities\CheckedCertificate;

class CertificateClient extends Client
{
    protected $basePath = 'ssl/';

    /**
     * Gets a paginated response of all certificates
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/certificates', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Certificate($item);
        });

        return $page;
    }

    /**
     * Gets an individual Certificate
     *
     * @param int $id
     * @return Certificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/certificates/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Certificate($body->data);
    }

    /**
     * Get certificate private key
     *
     * @param int $id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCertificatePrivateKey($id)
    {
        $response = $this->request("GET", "v1/certificates/$id/private-key");
        $body = $this->decodeJson($response->getBody()->getContents());

        return $body->data->key;
    }


    /**
     * Download certificate in PEM format
     *
     * @param int $id
     * @return CertificatePEM
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCertificatePEM($id)
    {
        $response = $this->request("GET", "v1/certificates/$id/download");
        $body = $this->decodeJson($response->getBody()->getContents());

        return new CertificatePEM($body->data);
    }

    /**
     * @param $hostname
     * @param $ip
     * @return CheckedCertificate
     */
    public function checkCertificate($hostname, $ip)
    {
        $data = [
            'hostname' => $hostname,
            'ip' => $ip
        ];

        $response = $this->post("v1/certificates/checker", json_encode($data));
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRequest($body->data);
    }

    /**
     * @param $data
     * @return CheckedCertificate
     */
    protected function serializeRequest($data)
    {
        $request = new Entities\CheckedCertificate;

        $request->validFrom = $data->ssl->certificate->valid_from;
        $request->validTo = $data->ssl->certificate->valid_to;
        $request->issuer = $data->ssl->certificate->issuer;
        $request->serialNumber = $data->ssl->certificate->serial_number;
        $request->signatureAlgorithm = $data->ssl->certificate->signature_algorithm;
        $request->domainCovered = $data->ssl->certificate->domain_covered;
        $request->ip = $data->ssl->server->ip;
        $request->hostname = $data->ssl->server->hostname;
        $request->port = $data->ssl->server->port;
        $request->currentTime = $data->ssl->server->current_time;
        $request->serverTime = $data->ssl->server->server_time;
        $request->serverSoftware = $data->ssl->server->server_software;
        $request->domainsSecured = $data->ssl->other->domains_secured;
        $request->multiDomain = $data->ssl->other->multi_domain;
        $request->wildcard = $data->ssl->other->wildcard;
        $request->heartbleedVulnerable = $data->ssl->other->heartbleed_vulnerable;
        $request->opensslVersion =$data->ssl->other->openssl_version;
        $request->sslVersions = $data->ssl->other->ssl_versions;
        $request->status = $data->validation->status;
        $request->error = (isset($data->validation->error)) ? $data->validation->error : null;

        return $request;
    }
}
