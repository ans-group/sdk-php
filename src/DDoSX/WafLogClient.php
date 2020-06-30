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
        "match_count" => "matchCount"
    ];

     /**
     * Gets a waf log
     *
     * @param string $requestId
     */
    public function getLog($requestId)
    {
        $response = $this->request("GET", 'v1/domains/waf/logs/' . $requestId);
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new WafLog($this->apiToFriendly($body->data, $this->requestMap));
    }
}
