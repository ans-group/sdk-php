<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class DomainClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * Gets a paginated response of all DDoSX domains
     *
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \UKFast\SDK\Exception\InvalidJsonException
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeDomain($item);
        });

        return $page;
    }

    /**
     * Gets an individual domain
     *
     * @param string $domainName
     * @return \UKFast\SDK\DDoSX\Entities\Domain
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \UKFast\SDK\Exception\InvalidJsonException
     */
    public function getByName($domainName)
    {
        $response = $this->request("GET", 'v1/domains/' . $domainName);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeDomain($body->data);
    }

    /**
     * Converts a response stdClass into a Domain object
     *
     * @param \stdClass
     * @return Entities\Domain
     */
    public function serializeDomain($item)
    {
        $domain = new Entities\Domain([
            'safednsZoneId' => $item->safedns_zone_id,
            'name' => $item->name,
            'status' => $item->status,
            'dnsActive' => $item->dns_active,
            'cdnActive' => $item->cdn_active,
            'wafActive' => $item->waf_active,
        ]);

        if (empty($item->external_dns) === false) {
            $domain->externalDns = new Entities\ExternalDns([
                'verified'           => $item->external_dns->verified,
                'verificationString' => $item->external_dns->verification_string,
                'dnsAliasTarget'     => $item->external_dns->target,
            ]);
        }

        return $domain;
    }
}
