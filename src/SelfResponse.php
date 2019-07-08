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
     * SelfResponse constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->id = $response->data->id;
        $this->location = $response->meta->location;
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
