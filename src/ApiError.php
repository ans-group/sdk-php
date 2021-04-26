<?php

namespace UKFast\SDK;

class ApiError
{
    /**
     * @var string $title
     */
    public $title;

    /**
     * @var string $detail
     */
    public $detail;

    /**
     * @var int $status
     */
    public $status;

    /**
     * @var int $source
     */
    public $source;

    public static function fromRaw($raw)
    {
        $requiredFields = ['title', 'detail', 'status', 'source'];
        $setFields = array_keys((array) $raw);
        if (empty(array_intersect($requiredFields, $setFields))) {
            return null;
        }

        $error = new static;
        foreach (get_object_vars($raw) as $key => $value) {
            $error->$key = $value;
        }

        return $error;
    }
}
