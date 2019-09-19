<?php

namespace UKFast\SDK\Exception;

use RuntimeException;

class UKFastException extends RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
