<?php

namespace UKFast\PHaaS;

use Psr\Http\Message\ResponseInterface;
use UKFast\Exception\ValidationException;
use UKFast\Page;
use UKFast\Client as BaseClient;

class DomainClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getDomains($page = 1, $perPage = 15, $filters = [])
    {
        $domains = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);

        $domains->serializeWith(function ($item) {
            return $this->serializeDomain($item);
        });

        return $domains;
    }

    /**
     * @param string $domain
     * @param string $verificationEmail
     * @return Domain
     */
    public function addDomain($domain, $verificationEmail)
    {
        if (empty($domain)) {
            throw new ValidationException("A domain must be provided");
        }

        if (empty($verificationEmail)) {
            throw new ValidationException("A verification email address must be provided");
        }

        $data = json_encode([
            "domain"             => $domain,
            "verification_email" => $verificationEmail
        ]);

        $response = $this->request("POST", 'v1/domains', $data, ['Content-Type' => 'application/json']);

        $domain = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeDomain($domain);
    }

    /**
     * @param string $domainId
     * @return Domain
     */
    public function resendValidationEmail($domainId)
    {
        if (empty($domainId)) {
            throw new ValidationException("A domain id must be provided");
        }

        $domain = $this->decodeJson($this->request("GET", "v1/domains/$domainId/resend-verification"));

        return $this->serializeDomain($domain);
    }

    /**
     * @param string $hash
     * @return ResponseInterface
     */
    public function verifyDomainHash($hash)
    {
        if (empty($hash) || strlen($hash) !== 28) {
            throw new ValidationException("A valid domain verification hash must be provided");
        }

        return $this->request("GET", "v1/domains/verify/$hash");
    }

    /**
     * @param $item
     * @return Domain
     */
    protected function serializeDomain($item)
    {
        $domain = new Domain;

        $domain->id = $item->id;
        $domain->domain = $item->domain;
        $domain->verificationEmail = $item->verification_email;
        $domain->verificationSent = $item->verification_sent;
        $domain->verificationDate = $item->verification_date;
        $domain->status = $item->status;
        $domain->createdAt = $item->created_at;
        $domain->updatedAt = $item->updated_at;

        return $domain;
    }
}
