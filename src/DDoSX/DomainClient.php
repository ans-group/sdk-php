<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Domain;
use UKFast\SDK\DDoSX\Entities\DomainProperty;
use UKFast\SDK\DDoSX\Entities\Ip;
use UKFast\SDK\SelfResponse;

class DomainClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * @var array
     */
    protected $requestMap = [];

    /**
     * @var array
     */
    const IP_MAP = [
        "ipv4_address" => "ipv4Address",
        "ipv6_address" => "ipv6Address"
    ];

    const PROPERTIES_MAP = [];

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
     * @param Domain $domain
     * @return SelfResponse
     */
    public function create(Domain $domain)
    {
        $response = $this->post('v1/domains', json_encode($this->friendlyToApi($domain, $this->requestMap)));
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body, "name"))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Domain($this->apiToFriendly($response->data, $this->requestMap));
            });
    }

    /**
     * @param Domain $domain
     * @return bool
     */
    public function deploy(Domain $domain)
    {
        $this->post('v1/domains/' . $domain->name . '/deploy');

        return true;
    }

    /**
     * @param $domainName
     * @return Ip
     */
    public function getIpByName($domainName)
    {
        $response = $this->request("GET", 'v1/domains/' . $domainName . '/ips');
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Ip($this->apiToFriendly($body->data, self::IP_MAP));
    }

    /**
     * Get a paginated list of domain properties
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filter
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getProperties($domainName, $page = 1, $perPage = 15, $filter = [])
    {
        $response = $this->paginatedRequest('v1/domains/' . $domainName . '/properties', $page, $perPage);

        $page = $response->serializeWith(function ($item) {
            return $this->serializeDomainProperty($item);
        });

        return $page;
    }

    /**
     * Get a property by it's ID
     * @param $domainId
     * @param $propertyId
     * @return DomainProperty
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPropertyById($domainId, $propertyId)
    {
        $response = $this->get('v1/domains/' . $domainId . '/properties/' . $propertyId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeDomainProperty($body->data);
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

    protected function serializeDomainProperty($raw)
    {
        return new DomainProperty($this->apiToFriendly($raw, self::PROPERTIES_MAP));
    }
}
