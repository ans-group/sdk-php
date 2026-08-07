<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\Lookup;

class LookupClient extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Lookup API fields which need mapping
     *
     * @var array
     */
    public $lookupMap = [
        'name' => 'name',
        'status' => 'status',
        'registrar' => 'registrar',
        'registry' => 'registry',
        'nameservers' => 'nameservers',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'expires_at' => 'expiresAt',
    ];

    /**
     * Looks up a domain
     *
     * @param string $domainName
     * @return Lookup
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecord($domainName)
    {
        $response = $this->request("GET", 'v2/lookup/' . $this->sanitiseDomain($domainName));
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Lookup($this->apiToFriendly($body->data, $this->lookupMap));
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
