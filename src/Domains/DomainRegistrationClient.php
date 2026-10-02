<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\Domain;
use UKFast\SDK\Domains\Entities\DomainAvailability;
use UKFast\SDK\Domains\Entities\DomainRegistration;
use UKFast\SDK\Domains\Entities\DomainRenewal;
use UKFast\SDK\SelfResponse;

class DomainRegistrationClient extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Check whether a domain name is available for registration
     *
     * @param string $domainName
     * @return DomainAvailability
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkAvailability($domainName)
    {
        $response = $this->post('v2/domains/availability', json_encode(['domain' => $domainName]));
        $body = $this->decodeJson($response->getBody()->getContents());
        return new DomainAvailability((array) $body->data);
    }

    /**
     * Register a domain
     *
     * @param DomainRegistration $registration
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register($registration)
    {
        $response = $this->post('v2/domains', json_encode($registration->toApiArray()));
        $responseBody = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($responseBody))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return new Domain($responseBody->data);
            });
    }

    /**
     * Gets whether a domain can be renewed now, and the price of each
     * renewal period
     *
     * @param string $domainName
     * @return DomainRenewal
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRenewal($domainName)
    {
        $response = $this->get("v2/domains/$domainName/renewal");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new DomainRenewal((array) $body->data);
    }

    /**
     * Renews a domain for $period years. This is a paid, non-refundable
     * purchase. $price must be the price getRenewal() gave for that period,
     * exactly as given (e.g. "36.75"): sending it back is how the renewal
     * accepts it, so a premium or changed price is never charged without
     * having been quoted.
     *
     * @param string $domainName
     * @param int $period
     * @param string $price
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renew($domainName, $period, $price)
    {
        $this->post("v2/domains/$domainName/renewal", json_encode([
            'period' => (int) $period,
            'price' => (string) $price,
        ]));

        return true;
    }
}
