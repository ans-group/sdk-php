<?php

namespace UKFast\Domains;

use UKFast\Client as BaseClient;
use UKFast\Page;

class Client extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Gets a paginated response of all Domains
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getDomains($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeDomain($item);
        });

        return $page;
    }

    /**
     * Gets an individual Domain
     *
     * @param string $name
     * @return Domain
     */
    public function getDomain($name)
    {
        $response = $this->request("GET", "v1/domains/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeDomain($body->data);
    }

    /**
     * Gets an individual Domains Nameservers
     *
     * @param string $name
     * @return Domain
     */
    public function getDomainNameservers($name)
    {
        $response = $this->request("GET", "v1/domains/$name/nameservers");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeNameserver($item);
        }, $body->data);
    }

    /**
     * Gets a domains WHOIS
     *
     * @param string $name
     * @return Whois
     */
    public function getWhois($name)
    {
        $response = $this->request("GET", "v1/whois/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeWhois($body->data);
    }

    /**
     * Gets a domain's raw WHOIS response
     *
     * @param string $name
     * @return Whois
     */
    public function getWhoisRaw($name)
    {
        $response = $this->request("GET", "v1/whois/$name/raw");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

    /**
     * Converts a response stdClass into a Domain object
     *
     * @param \stdClass $item
     * @return Domain
     */
    protected function serializeDomain($item)
    {
        $domain = new Domain;
        $domain->name = $item->name;
        $domain->status = $item->status;

        $domain->registrar = $item->registrar;

        $domain->registeredAt = $item->registered_at;
        $domain->updatedAt = $item->updated_at;
        $domain->renewalAt = $item->renewal_at;

        $domain->autoRenew = $item->auto_renew;
        $domain->whoisPrivacy = $item->whois_privacy;

        return $domain;
    }

    /**
     * Converts a response stdClass into a Nameserver object
     *
     * @param \stdClass $item
     * @return Nameserver
     */
    protected function serializeNameserver($item)
    {
        $nameserver = new Nameserver;
        $nameserver->host = $item->host;
        $nameserver->ip = $item->ip;

        return $nameserver;
    }

    /**
     * Converts a response stdClass into a Nameserver object
     *
     * @param \stdClass $item
     * @return Whois
     */
    protected function serializeWhois($item)
    {
        $whois = new Whois;
        $whois->name = $item->name;
        $whois->status = $item->status;

        $whois->createdAt = $item->created_at;
        $whois->updatedAt = $item->updated_at;
        $whois->expiresAt = $item->expires_at;

        $whois->nameservers = array_map(function ($item) {
            return $this->serializeNameserver($item);
        }, $item->nameservers);

        $whois->registrar = $this->serializeRegistrar($item->registrar);

        return $whois;
    }

    /**
     * Converts a response stdClass into a Registrar object
     *
     * @param \stdClass $item
     * @return Registrar
     */
    protected function serializeRegistrar($item)
    {
        $registrar = new Registrar;
        $registrar->name = $item->name;

        if (isset($item->url)) {
            $registrar->url = $item->url;
        }

        if (isset($item->tag)) {
            $registrar->tag = $item->tag;
        }

        if (isset($item->id)) {
            $registrar->icann_id = $item->id;
        }

        return $registrar;
    }
}
