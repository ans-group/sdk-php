<?php

namespace UKFast\Domains;

use UKFast\Domains\Entities\Whois;

class WhoisClient extends Client
{
    /**
     * Gets a parsed WHOIS record
     *
     * @param string $target
     * @return Whois
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
     */
    public function getRawRecord($fqdn)
    {
        $response = $this->request("GET", "v1/whois/$fqdn/raw");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $body->data;
    }

}
