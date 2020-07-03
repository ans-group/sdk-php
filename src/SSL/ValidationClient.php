<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\SSL\Entities\ValidationResult;

class ValidationClient extends BaseClient
{
    protected $basePath = 'ssl/';

    /**
     * Validation Result API fields which need to be mapped
     *
     * @var array
     */
    public $validationMap = [
        'expires_at' => 'expiresAt',
    ];

    /**
     * Validate a certificate against its key or key and CA bundle
     *
     * @param string $key
     * @param string $certificate
     * @param string|null $caBundle
     * @return ValidationResult
     */
    public function validate($key, $certificate, $caBundle = null)
    {
        $requestBody = [
            'key' => $key,
            'certificate' => $certificate,
        ];
        if (empty($caBundle) === false) {
            $requestBody['ca_bundle'] = $caBundle;
        }

        $response = $this->post("v1/validate", json_encode($requestBody));
        $body = $this->decodeJson($response->getBody()->getContents());

        return new ValidationResult($this->apiToFriendly($body->data, $this->validationMap));
    }
}
