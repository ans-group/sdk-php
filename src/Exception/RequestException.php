<?php

namespace UKFast\SDK\Exception;

class RequestException extends UKFastException
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
