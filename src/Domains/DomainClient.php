<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;
use UKFast\SDK\Domains\Entities\Domain;
use UKFast\SDK\Domains\Entities\DomainRegistrant;
use UKFast\SDK\Domains\Entities\DomainRegistrantAddress;
use UKFast\SDK\Domains\Entities\DomainRegistrantCompany;
use UKFast\SDK\Domains\Entities\DomainRegistrantContact;
use UKFast\SDK\Domains\Entities\Nameserver;

class DomainClient extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Gets a paginated response of all Domains
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/domains', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Domain($item);
        });

        return $page;
    }

    /**
     * Gets an individual Domain
     *
     * @param string $name
     * @return Domain
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByName($name)
    {
        $response = $this->request("GET", "v2/domains/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Domain($body->data);
    }

    /**
     * Updates a Domain. Only auto-renew is sent, and only when set.
     *
     * @param Domain $domain
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Domain $domain)
    {
        $data = [];

        if (!is_null($domain->autoRenew)) {
            $data['renewal'] = ['auto' => $domain->autoRenew];
        }

        $this->patch("v2/domains/{$domain->name}", json_encode($data));

        return true;
    }

    /**
     * Removes a Domain from the account. This only stops ANS tracking it:
     * the registration itself stays exactly as it is at the registry.
     *
     * @param string $name
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteByName($name)
    {
        $this->delete("v2/domains/$name");

        return true;
    }

    /**
     * Gets an individual Domains Nameservers
     *
     * @param string $name
     * @return Nameserver[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNameserversByName($name)
    {
        $response = $this->request("GET", "v2/domains/$name/nameservers");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return new Nameserver($item);
        }, $body->data);
    }

    /**
     * Replaces a Domains Nameservers with the given list (2 to 5). A
     * nameserver within the domain itself needs an IPv4 address.
     *
     * @param string $name
     * @param Nameserver[] $nameservers
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateNameservers($name, $nameservers)
    {
        $data = array_map(function ($nameserver) {
            return [
                'host' => $nameserver->host,
                'ip' => $nameserver->ip,
            ];
        }, array_values($nameservers));

        $this->put("v2/domains/$name/nameservers", json_encode($data));

        return true;
    }

    /**
     * Gets a Domains Registrant, as held at the registry
     *
     * @param string $name
     * @return DomainRegistrant
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRegistrantByName($name)
    {
        $response = $this->request("GET", "v2/domains/$name/registrant");
        $body = $this->decodeJson($response->getBody()->getContents());
        $data = $body->data;

        $registrant = new DomainRegistrant([
            'name' => isset($data->name) ? $data->name : null,
            'type' => isset($data->type) ? $data->type : null,
        ]);

        if (isset($data->company)) {
            $registrant->company = new DomainRegistrantCompany([
                'number' => isset($data->company->number) ? $data->company->number : null,
                'tradingAs' => isset($data->company->trading_as) ? $data->company->trading_as : null,
            ]);
        }

        if (isset($data->contact)) {
            $registrant->contact = new DomainRegistrantContact($data->contact);
        }

        if (isset($data->address)) {
            $registrant->address = new DomainRegistrantAddress($data->address);
        }

        return $registrant;
    }

    /**
     * Updates a Domains Registrant at the registry. The registrant's name
     * can't be changed this way, so it isn't sent. A null field is sent as
     * null, which clears it (e.g. a trading name or phone number).
     *
     * @param string $name
     * @param DomainRegistrant $registrant
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateRegistrant($name, DomainRegistrant $registrant)
    {
        $company = $registrant->company;
        $contact = $registrant->contact;
        $address = $registrant->address;

        $data = [
            'type' => $registrant->type,
            'company' => [
                'number' => $company ? $company->number : null,
                'trading_as' => $company ? $company->tradingAs : null,
            ],
            'contact' => [
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
            ],
            'address' => [
                'line1' => $address->line1,
                'line2' => $address->line2,
                'city' => $address->city,
                'county' => $address->county,
                'postcode' => $address->postcode,
                'country' => $address->country,
            ],
        ];

        $this->put("v2/domains/$name/registrant", json_encode($data));

        return true;
    }
}
