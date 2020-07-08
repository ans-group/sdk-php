<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafMatch;


class WafMatchClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * @var array
     */
    protected $requestMap = [
        "match_id" => "matchId",
        "request_id" => "requestId",
        "client_ip" => "clientIp",
        "request_uri" => "requestUri",
        "created_at" => "createdAt",
        "country_code" => "countryCode",
        "uri_part" => "uriPart"
    ];

     /**
     * Gets a waf match
     *
     * @param string $requestId
     * @param int $matchId
     */
    public function getMatch($requestId, $matchId)
    {
        $response = $this->request("GET", 'v1/waf/logs/' . $requestId . '/matches/' . $matchId);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new WafMatch($this->apiToFriendly($body->data, $this->requestMap));
    }
}
