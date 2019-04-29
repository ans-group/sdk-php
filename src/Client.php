<?php

namespace UKFast;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use UKFast\Exception\ApiException;
use UKFast\Exception\InvalidJsonException;
use UKFast\Exception\NotFoundException;

class Client
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    public function __construct(HttpClient $client = null)
    {
        if ($client) {
            $this->httpClient = $client;
            return;
        }

        return $this->httpClient = new HttpClient([
            'base_uri' => 'https://api.ukfast.io/' . $this->basePath,
            'headers' => [
                'User-Agent' => 'UKFast/1.0'
            ]
        ]);
    }

    /**
     * Sets the API key to be used by the client
     *
     * @param string $token
     * @return \UKFast\Client
     */
    public function auth($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Makes a HTTP request to the API
     *
     * @param string $method
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     *
     * @throws \UKFast\Exception\ApiException
     * @throws \UKFast\Exception\NotFoundException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $endpoint, $body = null, $headers = [])
    {
        $defaultHeaders = ['User-Agent' => 'UKFast/1.0'];
        
        if ($this->token) {
            $defaultHeaders['Authorization'] = $this->token;
        }

        try {
            $response = $this->httpClient->request($method, $endpoint, [
                'body' => $body,
                'headers' => array_merge($headers, $defaultHeaders),
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                throw new NotFoundException($e->getResponse());
            }

            throw new ApiException($e->getResponse());
        }

        return $response;
    }

    /**
     * Makes a request to a paginated endpoint
     *
     * @param string $endpoint
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function paginatedRequest($endpoint, $page, $perPage, $filters = [])
    {
        $url = (new PaginationUrl($endpoint, $page, $perPage, $filters))->toString();
        $response = $this->request('GET', $url);

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new Page($body->data, $body->meta, new Request("GET", $url)))
                  ->setClient($this);
    }

    /**
     * Convienience function for decoding json and checking
     * errors
     *
     * @param string $raw
     * @throws \UKFast\Exception\InvalidJsonException
     * @return mixed
     */
    protected function decodeJson($raw)
    {
        $decoded = json_decode($raw);
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidJsonException($err);
        }

        return $decoded;
    }
}
