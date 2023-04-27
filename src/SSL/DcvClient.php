<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Exception\ApiException;
use UKFast\SDK\SSL\Entities\Certificate;

class DcvClient extends BaseClient
{
    protected $basePath = 'ssl/';

    /**
     * Validates a certificate against dcv type
     *
     * @param Certificate $certificate
     * @return true
     * @throws ApiException
     */
    public function validate(Certificate $certificate)
    {
        $url = 'v1/dcv/' . urlencode($certificate->id) . '/validate';
        $this->post($url);

        return true;
    }
}
