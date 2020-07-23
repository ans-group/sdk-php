<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\WafLog;

class WafLogClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * @var array
     */
    protected $requestMap = [
        "request_id" => "requestId",
        "client_ip" => "clientIp",
        "created_at" => "createdAt"
    ];

    /**
     * Gets paginated list of waf logs
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/waf/logs', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new WafLog($this->apiToFriendly($item, $this->requestMap));
        });

        return $page;
    }

     /**
     * Gets a waf log
     *
     * @param string $requestId
     */
    public function getById($requestId)
    {
        $response = $this->request("GET", 'v1/waf/logs/' . $requestId);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new WafLog($this->apiToFriendly($body->data, $this->requestMap));
    }
}
