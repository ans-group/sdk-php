<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Exception\ApiException;
use UKFast\SDK\Exception\InvalidJsonException;

class ApiExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_from_standard_api_error()
    {
        $headers = [
            'Request-ID' => 'test-request-id',
        ];
        $response = new Response(500, $headers, json_encode([
            'errors' => [
                [
                    'detail' => 'Test'
                ]
            ]
        ]));

        $exception = new ApiException($response);

        $this->assertEquals(1, count($exception->getErrors()));
        $this->assertEquals('Test', $exception->getErrors()[0]->detail);
        $this->assertEquals('test-request-id', $exception->getRequestId());
    }

    /**
     * @test
     */
    public function constructs_from_api_gateway_error()
    {
        $response = new Response(401, [], json_encode([
            'message' => 'Invalid authentication credentials'
        ]));

        $exception = new ApiException($response);

        $this->assertEquals(1, count($exception->getErrors()));
        $this->assertEquals('API Gateway Error', $exception->getErrors()[0]->title);
        $this->assertEquals('Invalid authentication credentials', $exception->getErrors()[0]->detail);
        $this->assertEquals(401, $exception->getErrors()[0]->status);
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

    /**
     * @test
     */
    public function request_id_is_null_if_none_is_returned()
    {
        $response = new Response(500, [], json_encode([
            'errors' => [
                [
                    'detail' => 'Test'
                ]
            ]
        ]));

        $exception = new ApiException($response);

        $this->assertNull($exception->getRequestId());
    }
}