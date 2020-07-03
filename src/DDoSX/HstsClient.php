<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Hsts;
use UKFast\SDK\DDoSX\Entities\HstsRule;

class HstsClient extends BaseClient
{
    /**
     * @var string $basePath
     */
    protected $basePath = 'ddosx/';

    const HSTS_MAP = [];

    /**
     * Get the HSTS enabled status
     * @param $domainName
     * @return Hsts
     */
    public function getStatus($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts');
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeHsts($body->data);
    }

    protected function serializeHsts($raw)
    {
        return (new Hsts($this->apiToFriendly($raw, self::HSTS_MAP)));
    }
}
