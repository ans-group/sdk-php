<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\PaginationUrl;

class PaginationUrlTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_pagination_url()
    {
        $url = new PaginationUrl("/my-endpoint", 1, 10);
        $this->assertEquals("/my-endpoint?page=1&per_page=10", $url->toString());
    }

    /**
     * @test
     */
    public function removes_trailing_slash_from_endpoint()
    {
        $url = new PaginationUrl("/my-endpoint/", 1, 10);
        $this->assertEquals("/my-endpoint?page=1&per_page=10", $url->toString());
    }

    /**
     * @test
     */
    public function applies_filter_values()
    {
        $url = new PaginationUrl("/my-endpoint", 1, 10, ['id:eq' => 12]);
        $this->assertEquals("/my-endpoint?page=1&per_page=10&id%3Aeq=12", $url->toString());
    }

    /**
     * @test
     */
    public function url_encodes_filter_values()
    {
        $url = new PaginationUrl("/my-endpoint", 1, 10, ['desc:eq' => '99% Memory Usage']);
        $this->assertEquals("/my-endpoint?page=1&per_page=10&desc%3Aeq=99%25+Memory+Usage", $url->toString());
    }

    /**
     * @test
     */
    public function converts_filter_arrays_into_comma_delimited_string()
    {
        $url = new PaginationUrl("/my-endpoint", 1, 10, ['id:in' => [1, 2, 3, 4]]);
        $this->assertEquals("/my-endpoint?page=1&per_page=10&id%3Ain=1%2C2%2C3%2C4", $url->toString());
    }

    /**
     * @test
     */
    public function allows_booleans_to_be_passed_as_filters()
    {
        $url = new PaginationUrl("/my-endpoint", 1, 10, ['archived' => true]);
        $this->assertEquals("/my-endpoint?page=1&per_page=10&archived=true", $url->toString());
    }
}
