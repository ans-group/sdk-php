<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\Company;
use UKFast\SDK\Client as BaseClient;

class CompanyClient extends BaseClient
{
    protected $basePath = 'account/';

    /**
     * Gets company details
     *
     * @return Company
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDetails()
    {
        $response = $this->request("GET", "v1/details");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Company($body->data);
    }
}
