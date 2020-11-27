<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\AccessLog\AccessLog;
use UKFast\SDK\DDoSX\Entities\AccessLog\Origin;
use UKFast\SDK\DDoSX\Entities\AccessLog\Request;
use UKFast\SDK\DDoSX\Entities\AccessLog\Response;
use UKFast\SDK\Page;

class AccessLogClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * @var string[]
     */
    public static $logMap = [
        'created_at' => 'createdAt',
    ];

    /**
     * @var string[]
     */
    public static $requestMap = [
        'user_agent'   => 'userAgent',
        'http_version' => 'httpVersion',
        'client_ip'    => 'clientIp',
        'total_time'   => 'totalTime',
    ];

    /**
     * @var string[]
     */
    public static $originMap = [
        'total_time' => 'totalTime',
    ];

    /**
     * @var string[]
     */
    public static $responseMap = [
        'total_time' => 'totalTime',
    ];

    /**
     * Get a paginated response from a collection
     *
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return Page
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, static::$logMap);

        $page = $this->paginatedRequest('v1/access-logs', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * @param $data
     * @return AccessLog
     */
    public function loadEntity($data)
    {
        $accessLog           = new AccessLog($this->apiToFriendly($data, static::$logMap));
        $accessLog->request  = new Request($this->apiToFriendly($accessLog->request, static::$requestMap));
        $accessLog->origin   = new Origin($this->apiToFriendly($accessLog->origin, static::$originMap));
        $accessLog->response = new Response($this->apiToFriendly($accessLog->response, static::$responseMap));

        return $accessLog;
    }
}
