<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client;
use UKFast\SDK\Domains\Entities\Whois;

class WhoisClient extends Client
{
    protected $basePath = 'registrar/';

    /**
     * Gets a parsed WHOIS record
     *
     * @param string $target
     * @return Whois
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecord($target)
    {
        $response = $this->request("GET", "v1/whois/$target");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Whois($body->data);
    }

    /**
     * Gets a raw WHOIS record
     *
     * @param string $fqdn
     * @return Whois
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRawRecord($fqdn)
    {
        $response = $this->request("GET", "v1/whois/$fqdn/raw");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

    /**
     * @param string $domain
     * @return string
     */
    public function sanitiseDomain($domain)
    {
        $domain = trim($domain, '/ ');
        $domain = preg_replace('/^https?:\/\/?/', '', $domain);

        return rawurlencode($domain);
    }
}
