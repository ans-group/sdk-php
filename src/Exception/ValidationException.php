<?php

namespace UKFast\Exception;

class ValidationException extends UKFastException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
