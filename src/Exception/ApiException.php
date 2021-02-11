<?php

namespace UKFast\SDK\Exception;

use UKFast\SDK\ApiError;

class ApiException extends UKFastException
{
    /**
     * @var array|ApiError[]
     */
    protected $errors = [];

    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    public function __construct($response)
    {
        $response->getBody()->rewind();
        $this->response = $response;

        $raw = $response->getBody()->getContents();
        $body = json_decode($raw);
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg() . ': ' . $raw);
        }

        if (isset($body->errors) && is_array($body->errors)) {
            $this->errors = $this->getErrorsFromBody($body);
        } elseif (isset($body->message)) {
            $this->errors = $this->getApiGatewayErrorFromBody($body);
        }

        if (!empty($this->errors)) {
            $message = $this->errors[0]->detail;
            if (empty($message)) {
                $message = $this->errors[0]->title;
            }

            $this->message = $message;
        }
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
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed|null
     */
    public function getRequestId()
    {
        if (!empty($this->response->getHeader('Request-ID'))) {
            return $this->response->getHeader('Request-ID')[0];
        }

        return null;
    }

    /**
     * @param \stdClass $body
     * @return array
     */
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

    /**
     * @param \stdClass $body
     * @return ApiError[]
     */
    private function getApiGatewayErrorFromBody($body)
    {
        $error = new ApiError;
        $error->title = 'API Gateway Error';
        $error->detail = $body->message;
        $error->status = $this->response->getStatusCode();

        return [$error];
    }
}
