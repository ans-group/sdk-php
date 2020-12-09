<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Domain;
use UKFast\SDK\DDoSX\Entities\DomainProperty;
use UKFast\SDK\DDoSX\Entities\ExternalDns;
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

    const DOMAIN_MAP = [
        'safedns_zone_id' => 'safednsZoneId',
        'status'          => 'status',
        'dns_active'      => 'dnsActive',
        'cdn_active'      => 'cdnActive',
        'waf_active'      => 'wafActive',
    ];

    const EXTERNAL_DNS_MAP = [
        'verification_string' => 'verificationString',
        'target'              => 'dnsAliasTarget',
    ];

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
     * Get a paginated list of Domain properties
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filter
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getProperties($domainName, $page = 1, $perPage = 20, $filter = [])
    {
        $response = $this->paginatedRequest('v1/domains/' . $domainName . '/properties', $page, $perPage);

        $page = $response->serializeWith(function ($item) {
            return $this->serializeDomainProperty($item);
        });

        return $page;
    }

    /**
     * Get a Domain's property by its name
     * @param $domainName
     * @param $propertyId
     * @return DomainProperty
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPropertyById($domainName, $propertyId)
    {
        $response = $this->get('v1/domains/' . $domainName . '/properties/' . $propertyId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeDomainProperty($body->data);
    }

    /**
     * Delete a Domain by its domain name
     * @param $domainName
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($domainName)
    {
        $response = $this->delete('v1/domains/' . $domainName);
        return $response->getStatusCode() == 204;
    }

    /**
     * Converts a response stdClass into a Domain object
     *
     * @param \stdClass
     * @return Domain
     */
    public function serializeDomain($item)
    {
        $domain = new Domain($this->apiToFriendly($item, static::DOMAIN_MAP));

        if (empty($item->external_dns) === false) {
            $domain->externalDns  = new ExternalDns($this->apiToFriendly(
                $domain->external_dns,
                static::EXTERNAL_DNS_MAP
            ));
        }

        //$domain->syncOriginalAttributes();

        return $domain;
    }

    /**
     * @param $domainName
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function activateProtection($domainName)
    {
        $response = $this->post('v1/domains/' . $domainName . '/dns/active');

        return $response->getStatusCode() == 200;
    }

    /**
     * @param $domainName
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deactivateProtection($domainName)
    {
        $response = $this->delete('v1/domains/' . $domainName . '/dns/active');

        return $response->getStatusCode() == 200;
    }

    /**
     * @param $raw
     * @return DomainProperty
     */
    protected function serializeDomainProperty($raw)
    {
        return new DomainProperty($this->apiToFriendly($raw, self::PROPERTIES_MAP));
    }
}
