<?php

namespace UKFast\Exception;

class ApiException extends UKFastException
{
    protected $response;

    protected $errors;

    public function __construct($response)
    {
        $body = json_decode($response->getBody()->getContents());
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidJsonException($err);
        }
        
        $this->errors = $body->errors;
        $this->message = is_array($body->errors) ? $body->errors[0]->detail : $body->errors;
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
}
