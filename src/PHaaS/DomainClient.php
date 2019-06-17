<?php

namespace UKFast\PHaaS;

use Exception;
use Psr\Http\Message\ResponseInterface;
use UKFast\Page;
use UKFast\Client as BaseClient;
use UKFast\PHaaS\Entities\Domain;

class DomainClient extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * Get a paginated list of domains
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $domains = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);

        $domains->serializeWith(function ($item) {
            return new Domain($item);
        });

        return $domains;
    }

    /**
     * Add a single domain
     *
     * @param string $domain
     * @param string $verificationEmail
     * @return Domain
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addDomain($domain, $verificationEmail)
    {
        $data = json_encode([
            "domain"             => $domain,
            "verification_email" => $verificationEmail
        ]);

        $response = $this->post('v1/domains', $data);

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Resend validation email for a domain by domain id
     *
     * @param string $domainId
     * @return Domain
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resendValidationEmail($domainId)
    {
        $response = $this->get("v1/domains/$domainId/resend-verification");

        $body = $this->decodeJson($response->getBody()->getContents());

        return new Domain($body->data);
    }

    /**
     * Validate the domain hash
     *
     * @param string $hash
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyDomainHash($hash)
    {
        return $this->get( "v1/domains/verify/$hash");
    }
}
