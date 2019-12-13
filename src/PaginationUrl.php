<?php

namespace UKFast\SDK;

class PaginationUrl
{
    protected $path;

    protected $page;

    protected $perPage;

    protected $filters;

    public function __construct($path, $page, $perPage, $filters = [])
    {
        $this->path = $path;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->filters = $filters;
    }

    public function toString()
    {
        $path = $this->path;
        if (substr($path, -1) === "/") {
            $path = substr($path, 0, strlen($path) - 1);
        }

        $startQuery = "?";
        if (strpos($path, "?") !== false) {
            $startQuery = "&";
        }

        $path .= "{$startQuery}page=".$this->page;
        $path .= "&per_page=".$this->perPage;

        foreach ($this->filters as $prop => $filter) {
            if (is_array($filter)) {
                $filter = implode(",", $filter);
            }
            if (is_bool($filter)) {
                $filter = var_export($filter, true);
            }
            $path .= "&".$prop."=".$filter;
        }

        return $path;
    }
}
