<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafLogMatch;


class WafLogMatchClient extends BaseClient
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
     * Gets a waf log matches for a request
     *
     * @param string $requestId
     */
    public function getById($requestId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/waf/logs/' . $requestId . '/matches', $page, $perPage, $filters);
        
        $page->serializeWith(function ($item) {
            return new WafLogMatch($this->apiToFriendly($item, $this->requestMap));
        });
        
        return $page;
    }

     /**
     * Gets a waf log match from a request
     *
     * @param string $requestId
     * @param int $matchId
     */
    public function getRequestMatchById($requestId, $matchId)
    {
        $response = $this->request("GET", 'v1/waf/logs/' . $requestId . '/matches/' . $matchId);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new WafLogMatch($this->apiToFriendly($body->data, $this->requestMap));
    }
}
