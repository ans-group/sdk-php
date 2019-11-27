<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\SSL\Entities\Report;
use UKFast\SDK\SSL\Entities\ReportCertificate;

class ReportClient extends Client implements ClientEntityInterface
{
    protected $basePath = 'ssl/';

    /**
     * @param $domain
     * @return mixed|Report
     * @throws \Exception
     */
    public function getByDomainName($domain)
    {
        $response = $this->get("v1/report/" . rawurlencode($domain));
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $domain
     * @param $ip
     * @return mixed|Report
     * @throws \Exception
     */
    public function getByDomainNameAndIp($domain, $ip)
    {
        $response = $this->get("v1/reports/" . rawurlencode($domain) . "/" . rawurlencode($ip));
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return mixed|Report
     * @throws \Exception
     */
    public function loadEntity($data)
    {
        $chain = [];
        if (count($data->chain) > 0) {
            foreach ($data->chain->certificates as $index => $certification) {
                $chain['certificates'][] = new Entities\ReportCertificate([
                    "name" => $data->chain->certificates[$index]->name,
                    "validFrom" => new \DateTime($data->chain->certificates[$index]->valid_from),
                    "validTo" => new \DateTime($data->chain->certificates[$index]->valid_to),
                    "issuer" => $data->chain->certificates[$index]->issuer,
                    "serialNumber" => $data->chain->certificates[$index]->serial_number,
                    "signatureAlgorithm" => $data->chain->certificates[$index]->signature_algorithm,
                    "chainIntact" => $data->chain->certificates[$index]->chain_intact
                ]);
            }
        }

        $request = new Entities\Report([
            "name" => $data->certificate->name,
            "validFrom" => new \DateTime($data->certificate->valid_from),
            "validTo" => new \DateTime($data->certificate->valid_to),
            "issuer" => $data->certificate->issuer,
            "serialNumber" => $data->certificate->serial_number,
            "signatureAlgorithm" => $data->certificate->signature_algorithm,
            "coversDomain" => $data->certificate->covers_domain,
            "domainsSecured" => $data->certificate->domains_secured,
            "multiDomain" => $data->certificate->multi_domain,
            "wildcard" => $data->certificate->wildcard,
            "expiring" => $data->certificate->expiring,
            "expired" => $data->certificate->expired,
            "secureSha" => $data->certificate->secure_sha,
            "ip" => $data->server->ip,
            "hostname" => $data->server->hostname,
            "port" => $data->server->port,
            "currentTime" => new \DateTime($data->server->current_time),
            "serverTime" => new \DateTime($data->server->server_time),
            "serverSoftware" => $data->server->software,
            "opensslVersion" => $data->server->openssl_version,
            "sslVersions" => $data->server->ssl_versions,
            "vulnerabilities" => [
                "heartbleed" => $data->vulnerabilities->heartbleed,
                "poodle" => $data->vulnerabilities->poodle
            ],
            "chain" => $chain,
            "chainIntact" => $data->chain_intact,
            "findings" => $data->findings,
        ]);

        return $request;
    }
}
