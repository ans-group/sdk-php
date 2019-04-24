<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use UKFast\Page;

class PageTest extends TestCase
{
    /**
     * @test
     */
    public function parses_pagination_meta()
    {
        $page = new Page([(object) [
            'id' => 1,
            'name' => 'test'
        ]], (object) [
            'pagination' => (object) [
                'total' => 2,
                'count' => 1,
                'per_page' => 1,
                'links' => (object) [
                    'next' => 'http://example.com/next',
                    'previous' => null,
                    'first' => 'http://example.com/first',
                    'last' => 'http://example.com/last'
                ]
            ]
        ]);

        $this->assertEquals('http://example.com/next', $page->nextPageUrl());
        $this->assertEquals(null, $page->previousPageUrl());
        $this->assertEquals('http://example.com/first', $page->firstPageUrl());
        $this->assertEquals('http://example.com/last', $page->lastPageUrl());
    }
}