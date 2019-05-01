<?php

namespace UKFast\SSL;

use UKFast\Client as BaseClient;
use UKFast\Page;

class Client extends BaseClient
{
    protected $basePath = 'ssl';

    /**
     * Gets a paginated response of all certificates
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getCertificates($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('/ssl/v1/certificates', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeCertificate($item);
        });

        return $page;
    }

    /**
     * Gets an individual Certificate
     *
     * @param int $id
     * @return Certificate
     */
    public function getCertificate($id)
    {
        $response = $this->request("GET", "/ssl/v1/certificates/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeCertificate($body->data);
    }

    /**
     * Get certificate private key
     *
     * @param int $id
     * @return string
     */
    public function getCertificatePrivateKey($id)
    {
        $response = $this->request("GET", "/ssl/v1/certificates/$id/private-key");
        $body = $this->decodeJson($response->getBody()->getContents());

        return $body->data->key;
    }


    /**
     * Download certificate in PEM format
     *
     * @param int $id
     * @return CertificatePEM
     */
    public function getCertificatePEM($id)
    {
        $response = $this->request("GET", "/ssl/v1/certificates/$id/download");
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeCertificatePEM($body->data);
    }

    /**
     * Converts a response stdClass into a Certificate object
     *
     * @param \stdClass $item
     * @return Certificate
     */
    protected function serializeCertificate($item)
    {
        $certificate = new Certificate;

        $certificate->id = $item->id;

        $certificate->name = $item->name;
        $certificate->status = $item->status;

        $certificate->commonName = $item->common_name;
        $certificate->alternativeNames = $item->alternative_names;

        $certificate->validDays = $item->valid_days;
        $certificate->orderedDate = $item->ordered_date;
        $certificate->renewalDate = $item->renewal_date;

        return $certificate;
    }

    /**
     * Converts a response stdClass into a Certificate PEM object
     *
     * @param \stdClass $item
     * @return CertificatePEM
     */
    protected function serializeCertificatePEM($item)
    {
        $pem = new CertificatePEM;
        $pem->server = $item->server;
        $pem->intermediate = $item->intermediate;

        return $pem;
    }
}
