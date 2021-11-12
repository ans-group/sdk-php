<?php

namespace UKFast\SDK;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use UKFast\SDK\Exception;

class Client
{
    const VERSION = 1;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var HttpClient
     */
    protected $httpClient;


    /**
     * Client constructor.
     * @param HttpClient|null $client
     */
    public function __construct(HttpClient $client = null)
    {
        if ($client) {
            return $this->httpClient = $client;
        }

        return $this->httpClient = new HttpClient([
            'base_uri' => 'https://api.ukfast.io/' . $this->basePath,
            'headers' => [
                'User-Agent' => $this->getUserAgent()
            ]
        ]);
    }

    /**
     * Sets the API key to be used by the client
     *
     * @param string $token
     * @return $this
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
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function request($method, $endpoint, $body = null, $headers = [])
    {
        $defaultHeaders = $this->httpClient->getConfig()['headers'];
        if ($this->token) {
            $defaultHeaders['Authorization'] = $this->token;
        }
        
        $params = [
            'body' => $body,
            'headers' => array_merge($headers, $defaultHeaders),
        ];

        if (empty($body) && in_array($method, ['POST', 'PATCH', 'DELETE'])) {
            unset($params['body']);
        }

        try {
            $response = $this->httpClient->request($method, $endpoint, $params);
        } catch (ClientException $e) {
            $status = $e->getResponse()->getStatusCode();

            if ($status == 404) {
                throw new Exception\NotFoundException($e->getResponse());
            }

            if ($status == 400 || $status == 422) {
                throw new Exception\ValidationException($e->getResponse());
            }

            if ($status == 412) {
                throw new Exception\PreconditionFailedException($e->getResponse());
            }

            throw new Exception\ClientException($e->getResponse());
        } catch (ServerException $e) {
            throw new Exception\ServerException($e->getResponse());
        }

        return $response;
    }

    /**
     * Convenience method for GET requests
     *
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function get($endpoint, $body = null, $headers = [])
    {
        return $this->request('GET', $endpoint, $body, $headers);
    }

    /**
     * Convenience method for POST requests
     *
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function post($endpoint, $body = null, $headers = [])
    {
        $headers = array_merge([
            'Content-Type'=>'application/json'
        ], $headers);

        return $this->request('POST', $endpoint, $body, $headers);
    }

    /**
     * Convenience method for PUT requests
     *
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function put($endpoint, $body = null, $headers = [])
    {
        $headers = array_merge([
            'Content-Type'=>'application/json'
        ], $headers);

        return $this->request('PUT', $endpoint, $body, $headers);
    }

    /**
     * Convenience method for PATCH requests
     *
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function patch($endpoint, $body = null, $headers = [])
    {
        $headers = array_merge([
            'Content-Type'=>'application/json'
        ], $headers);

        return $this->request('PATCH', $endpoint, $body, $headers);
    }

    /**
     * Convenience method for DELETE requests
     *
     * @param string $endpoint
     * @param string $body
     * @param array $headers
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function delete($endpoint, $body = null, $headers = [])
    {
        return $this->request('DELETE', $endpoint, $body, $headers);
    }

    /**
     * Makes a request to a paginated endpoint
     *
     * @param string $endpoint
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @param array $headers
     * @throws GuzzleException
     * @return Page
     */
    public function paginatedRequest($endpoint, $page, $perPage, $filters = [], $headers = [])
    {
        $url = (new PaginationUrl($endpoint, $page, $perPage, $filters))->toString();

        $response = $this->request('GET', $url, null, $headers);

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new Page($body->data, $body->meta, new Request("GET", $url)))
                  ->setClient($this);
    }

    /**
     * Convenience function for decoding json and checking errors
     *
     * @param string $raw
     * @throws Exception\InvalidJsonException
     * @return mixed
     */
    protected function decodeJson($raw)
    {
        $decoded = json_decode($raw);
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new Exception\InvalidJsonException(json_last_error_msg() . ': ' . $raw);
        }

        return $decoded;
    }

    /**
     * Return SDK User-Agent
     * @return string
     */
    protected function getUserAgent()
    {
        return implode(' ', [
            'ukfast-sdk-php/' . static::VERSION . '',
            'php/'.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION
        ]);
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param array|Entity $item
     * @param array $map
     * @return array
     */
    public function apiToFriendly($item, $map)
    {
        $newItem = [];
        if ($item instanceof Entity) {
            $item = $item->toArray();
        }
        foreach ($item as $key => $value) {
            if ($value instanceof Entity) {
                $value = $value->toArray();
            }
            $keyParts = explode(':', $key);
            $key = array_shift($keyParts);
            $filter = array_shift($keyParts);
            $filter = !empty($filter) ? ':' . $filter : '';
            $newItem[(isset($map[$key]) ? $map[$key] : $key) . $filter] = $value;
        }
        return $newItem;
    }

    /**
     * @param array|Entity $item
     * @param array $map
     * @return array
     */
    public function friendlyToApi($item, $map)
    {
        return $this->apiToFriendly($item, array_flip($map));
    }
}
