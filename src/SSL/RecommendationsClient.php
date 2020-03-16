<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\SSL\Entities\Recommendations;

class RecommendationsClient extends BaseClient
{
    protected $basePath = 'ssl/';

    protected $requestMap = [];

    /**
     * @param $domainName
     * @return Recommendation
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecommendations($domainName)
    {
        $response = $this->request("GET", 'v1/recommendations/' . $domainName);
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Recommendations($this->apiToFriendly($body->data, $this->requestMap));
    }
}
