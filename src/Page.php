<?php

namespace UKFast\SDK;

use Closure;
use GuzzleHttp\Psr7\Request;
use UKFast\SDK\Client;
use UKFast\SDK\Exception\InvalidJsonException;

/**
 * @template T of Entity
 */
class Page
{
    /**
     * @var array<int, T>
     */
    protected $items;

    /**
     * @var stdClass
     */
    protected $meta;

    /**
     * @var \GuzzleHttp\Psr7\Request
     */
    protected $request;

    /**
     * @var Closure|null
     */
    protected $serializer;
    
    /**
     * @var \UKFast\SDK\Client
     */
    protected $client;

    public function __construct($items, $meta, $request)
    {
        $this->items = $items;
        $this->meta = $meta;
        $this->request = $request;
    }

    /**
     * @return array<int, T>
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Setter for page items
     *
     * @param array<int, T> $items
     * @return array<int, T>
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this->items;
    }

    /**
     * Sets a mapping function to serialize each
     * item in a new page with
     *
     * @param Closure $callback
     * @return Page<T>
     */
    public function serializeWith($callback)
    {
        $this->serializer = $callback;
        $this->setItems($this->map($this->serializer));
        return $this;
    }

    /**
     * Applies a callback to each item in the page
     * and returns the resulting array
     *
     * @param Closure $callback
     * @return array
     */
    public function map($callback)
    {
        $new = [];
        foreach ($this->getItems() as $item) {
            $new[] = $callback($item);
        }

        return $new;
    }

    /**
     * Sets client to use when making requests
     * to other pages
     *
     * @param Client $client
     * @return Page<T>
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return string
     */
    public function nextPageUrl()
    {
        return $this->getLink('next');
    }

    /**
     * @return string
     */
    public function previousPageUrl()
    {
        return $this->getLink('previous');
    }

    /**
     * @return string
     */
    public function firstPageUrl()
    {
        return $this->getLink('first');
    }

    /**
     * @return string
     */
    public function lastPageUrl()
    {
        return $this->getLink('last');
    }

    /**
     * @return int
     */
    public function totalItems()
    {
        return $this->getPagination('total');
    }

    /**
     * @return int
     */
    public function totalPages()
    {
        return $this->getPagination('total_pages');
    }

    /**
     * @return int
     */
    public function perPage()
    {
        return $this->getPagination('per_page');
    }

    /**
     * @return int
     */
    public function pageNumber()
    {
        $query = $this->request->getUri()->getQuery();
        $params = [];
        parse_str($query, $params);

        return isset($params['page']) ? (int)$params['page'] : 1;
    }

    /**
     * Gets a page by number
     *
     * @param int $number
     * @return Page<T>
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \UKFast\SDK\Exception\InvalidJsonException
     */
    public function getPage($number)
    {
        $params = $this->queryParams();
        $params['page'] = $number;
        $newQuery = http_build_query($params);
        $uri = $this->request->getUri()->withQuery($newQuery);

        $response = $this->client->request("GET", $uri);
        return $this->constructNewPage($response, $uri);
    }

    /**
     * @return Page<T>|false
     */
    public function getNextPage()
    {
        if (!$this->nextPageUrl()) {
            return false;
        }

        $response = $this->client->request("GET", $this->nextPageUrl());
        return $this->constructNewPage($response, $this->nextPageUrl());
    }

    /**
     * @return Page<T>|false
     */
    public function getPreviousPage()
    {
        if (!$this->previousPageUrl()) {
            return false;
        }

        $response = $this->client->request("GET", $this->previousPageUrl());
        return $this->constructNewPage($response, $this->previousPageUrl());
    }

    /**
     * @return Page<T>
     */
    public function getFirstPage()
    {
        $response = $this->client->request("GET", $this->firstPageUrl());
        return $this->constructNewPage($response, $this->firstPageUrl());
    }

    /**
     * @return Page<T>
     */
    public function getLastPage()
    {
        $response = $this->client->request("GET", $this->lastPageUrl());
        return $this->constructNewPage($response, $this->lastPageUrl());
    }

    /**
     * Creates a new page from a response and the URI used to create
     * the page
     *
     * @param Response $response
     * @param string|\Psr\Http\Message\UriInterface $uri
     * @return Page<T>
     * @throws \UKFast\SDK\Exception\InvalidJsonException
     */
    private function constructNewPage($response, $uri)
    {
        $raw = $response->getBody()->getContents();
        $body = json_decode($raw);

        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg() . ': ' . $raw);
        }

        $next = new static($body->data, $body->meta, new Request("GET", $uri));
        $next->setClient($this->client);

        if ($this->serializer) {
            $next->serializeWith($this->serializer);
        }

        return $next;
    }

    /**
     * Retrieves a key's value from pagination metadata
     *
     * @param string $key
     * @param $default
     * @return mixed
     */
    private function getPagination($key, $default = null)
    {
        $pagination = $this->meta->pagination;
        return isset($pagination->{$key}) ? $pagination->{$key} : $default;
    }

    /**
     * Gets a key's value from link metadata
     *
     * @param string $key
     * @return string|null
     */
    private function getLink($link)
    {
        $links = $this->getPagination('links');
        return isset($links->{$link}) ? $links->{$link} : null;
    }

    /**
     * @return array
     */
    private function queryParams()
    {
        $query = $this->request->getUri()->getQuery();
        $params = [];
        parse_str($query, $params);
        return $params;
    }
}
