<?php

namespace UKFast\SDK\Exception;

use UKFast\SDK\ApiError;

class ApiException extends UKFastException
{
    protected $errors = [];

    protected $response;

    public function __construct($response)
    {
        $response->getBody()->rewind();
        $body = json_decode($response->getBody()->getContents());
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidJsonException($err);
        }

        if (isset($body->errors) && is_array($body->errors)) {
            $this->errors = $this->getErrorsFromBody($body);
        }

        if (!empty($this->errors)) {
            $this->message = $this->errors[0]->title;
        }

        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return int
     */
    public function getResponse()
    {
        return $this->response;
    }

    private function getErrorsFromBody($body)
    {
        $errors = [];
        foreach ($body->errors as $error) {
            $serialized = ApiError::fromRaw($error);
            if (!$serialized) {
                continue;
            }
            $errors[] = $serialized;
        }

        return $errors;
    }
}
