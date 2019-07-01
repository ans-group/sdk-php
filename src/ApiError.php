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
        if (isset($raw->title)) {
            $error->title = $raw->title;
        }

        if (isset($raw->detail)) {
            $error->detail = $raw->detail;
        }

        if (isset($raw->status)) {
            $error->status = $raw->status;
        }

        if (isset($raw->source)) {
            $error->source = $raw->source;
        }

        return $error;
    }
}
