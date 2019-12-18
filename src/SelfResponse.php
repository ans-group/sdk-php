<?php

namespace UKFast\SDK;

class SelfResponse
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var callable
     */
    protected $serializer;

    /**
     * @var \UKFast\SDK\Client
     */
    protected $client;

    /**
     * SelfResponse constructor.
     * @param $response
     * @param string $idProperty
     */
    public function __construct($response, $idProperty = "id")
    {
        $this->id = $response->data->{$idProperty};
        $this->location = $response->meta->location;
    }

    /**
     * Return the newly created resource
     * @return mixed
     */
    public function get()
    {
        $response = $this->client->request("GET", $this->getLocation());
        $response->getBody()->rewind();
        $response = json_decode($response->getBody()->getContents());

        $serializer = $this->serializer;

        return $serializer($response);
    }

    /**
     * Sets client to use when making requests
     * to other pages
     *
     * @param \UKFast\SDK\Client $client
     * @return \UKFast\SDK\SelfResponse
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Sets a mapping function to serialize each
     * item in a new page with
     *
     * @param \Closure $callback
     * @return \UKFast\SDK\SelfResponse
     */
    public function serializeWith($callback)
    {
        $this->serializer = $callback;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
