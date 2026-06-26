<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\Domain;
use UKFast\SDK\Domains\Entities\DomainAvailability;
use UKFast\SDK\Domains\Entities\DomainRegistration;
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

        return (new SelfResponse($responseBody, 'name'))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return new Domain($responseBody->data);
            });
    }
}
