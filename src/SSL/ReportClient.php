<?php

namespace UKFast\SDK\SSL;

use UKFast\Admin\Traits\Admin;
use UKFast\SDK\Client;
use UKFast\SDK\Entities\ClientEntityInterface;

class ReportClient extends Client implements ClientEntityInterface
{
    use Admin;
    
    protected $basePath = 'ssl/';

    /**
     * @param $domain
     * @param $ip
     * @return Entities\CheckedCertificate
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @return Entities\CheckedCertificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDomainNameAndIp($domain, $ip)
    {
        $response = $this->get("v1/report/" . rawurlencode($domain) . "/" . rawurlencode($ip));
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }


    /**
     * @param $data
     * @return mixed|Entities\CheckedCertificate
     */
    public function loadEntity($data)
    {
        $chain = [];
        if (count($data->chain) > 0) {
            foreach ($data->chain as $index => $certification) {
                $chain[] = new Entities\ReportCertificate([
                    "name" => $data->chain->{$index}->name,
                    "validFrom" => $data->chain->{$index}->valid_from,
                    "validTo" => $data->chain->{$index}->valid_to,
                    "issuer" => $data->chain->{$index}->issuer,
                    "serialNumber" => $data->chain->{$index}->serial_number,
                    "signatureAlgorithm" => $data->chain->{$index}->signature_algorithm
                ]);
            }
        }

        $request = new Entities\Report([
            "name" => $data->certificate->name,
            "validFrom" => $data->certificate->valid_from,
            "validTo" => $data->certificate->valid_to,
            "issuer" => $data->certificate->issuer,
            "serialNumber" => $data->certificate->serial_number,
            "signatureAlgorithm" => $data->certificate->signature_algorithm,
            "domainCovered" => $data->certificate->domain_covered,
            "domainsSecured" => $data->certificate->domains_secured,
            "multiDomain" => $data->certificate->multi_domain,
            "wildcard" => $data->certificate->wildcard,
            "certExpiresInLessThan30Days" => $data->certificate->cert_expires_in_less_than_thirty_days,
            "certExpired" => $data->certificate->cert_expired,
            "secureSha" => $data->certificate->secure_sha,
            "ip" => $data->server->ip,
            "hostname" => $data->server->hostname,
            "port" => $data->server->port,
            "currentTime" => $data->server->current_time,
            "serverTime" => $data->server->server_time,
            "serverSoftware" => $data->server->software,
            "opensslVersion" >=$data->server->openssl_version,
            "sslVersions" => $data->server->ssl_versions,
            "vulnerabilities" => [
                "heartbleed" => $data->vulnerabilities->heartbleed,
                "poodle" => $data->vulnerabilities->poodle
            ],
            "chain" => $chain,
            "status" => $data->validation->status,
            "error" => (isset($data->validation->error)) ? $data->validation->error : null,
        ]);
        
        return $request;
    }
}
