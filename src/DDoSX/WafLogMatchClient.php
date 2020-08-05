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
        "log_id" => "logId",
        "client_ip" => "clientIp",
        "request_uri" => "requestUri",
        "created_at" => "createdAt",
        "country_code" => "countryCode",
        "match_data" => "matchData",
        "uri_part" => "uriPart"
    ];

    /**
     * Gets a waf log matches for a waf log
     *
     * @param string $logId
     */
    public function getPageByRequestId($logId, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/waf/logs/' . $logId . '/matches', $page, $perPage, $filters);
        
        $page->serializeWith(function ($item) {
            return new WafLogMatch($this->apiToFriendly($item, $this->requestMap));
        });
        
        return $page;
    }

     /**
     * Gets a waf log match from a waf log
     *
     * @param string $logId
     * @param int $id
     */
    public function getRequestMatchById($logId, $id)
    {
        $response = $this->request("GET", 'v1/waf/logs/' . $logId . '/matches/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new WafLogMatch($this->apiToFriendly($body->data, $this->requestMap));
    }

    /**
     * Gets a list of all waf log matches
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/waf/logs/matches', $page, $perPage, $filters);
        
        $page->serializeWith(function ($item) {
            return new WafLogMatch($this->apiToFriendly($item, $this->requestMap));
        });
        
        return $page;
    }
}
