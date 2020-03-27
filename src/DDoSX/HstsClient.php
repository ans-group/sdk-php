<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\DDoSX\Entities\Hsts;

class HstsClient extends Client
{
    const HSTS_MAP = [];

    public function getStatus($domainName)
    {
        $response = $this->get('v1/domains/' . $domainName . '/hsts');
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    protected function serializeData($raw)
    {
        return (new Hsts($this->apiToFriendly($raw, self::HSTS_MAP)));
    }
}
