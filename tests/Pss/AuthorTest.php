<?php

namespace Tests\Pss;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\PSS\Entities\Author;

class AuthorTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_from_response()
    {
        $author = new Author((object) [
            'id' => 1,
            'name' => 'Test User',
            'type' => 'Client'
        ]);

        $this->assertEquals(1, $author->id);
        $this->assertEquals('Test User', $author->name);
        $this->assertEquals('Client', $author->type);
    }

    /**
     * @test
     */
    public function can_determine_if_support()
    {
        $author = new Author((object) [
            'id' => 1,
            'type' => 'Support',
            'name' => 'Test User',
        ]);

        $this->assertTrue($author->isSupport());
    }

    /**
     * @test
     */
    public function can_determine_if_client()
    {
        $author = new Author((object) [
            'id' => 1,
            'type' => 'Client',
            'name' => 'Test User',
        ]);

        $this->assertTrue($author->isClient());
    }

    /**
     * @test
     */
    public function can_determine_if_automated()
    {
        $author = new Author((object) [
            'id' => 1,
            'type' => 'Automated',
            'name' => 'Test User',
        ]);

        $this->assertTrue($author->isAutomated());
    }
}
