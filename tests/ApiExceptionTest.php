<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\Exception\ApiException;
use UKFast\Exception\InvalidJsonException;

class ApiExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_from_standard_api_error()
    {
        $response = new Response(500, [], json_encode([
            'errors' => [
                [
                    'detail' => 'Test'
                ]
            ]
        ]));

        $exception = new ApiException($response);

        $this->assertEquals(1, count($exception->getErrors()));
        $this->assertEquals('Test', $exception->getErrors()[0]->detail);
    }

    /**
     * @test
     */
    public function constructs_from_invalid_api_response()
    {
        $response = new Response(500, [], json_encode([
            'errors' => [
                'not a valid error object'
            ]
        ]));

        $exception = new ApiException($response);

        $this->assertEquals(0, count($exception->getErrors()));
    }

    /**
     * @test
     */
    public function throws_invalid_json_exception_when_given_bad_json()
    {
        $response = new Response(500, [], '{"errors": "bad json');

        $this->expectException(InvalidJsonException::class);
        $exception = new ApiException($response);
    }
}