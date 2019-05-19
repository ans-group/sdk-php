<?php

namespace UKFast\Account;

use UKFast\Account\Entities\Company;

class CompanyClient extends Client
{
    /**
     * Gets company details
     *
     * @return Company
     */
    public function getDetails()
    {
        $response = $this->request("GET", "v1/details");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Company($body->data);
    }
}
