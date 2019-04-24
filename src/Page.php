<?php

namespace UKFast;

use UKFast\Client;

class Page
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var stdClass
     */
    protected $meta;

    public function __construct($items, $meta)
    {
        $this->items = $items;
        $this->meta = $meta;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Setter for page items
     *
     * @param array $items
     * @return \UKFast\Page
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this->items;
    }

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
     * @param \UKFast\Client $client
     * @return \UKFast\Page
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

    private function getPagination($key, $default = null)
    {
        $pagination = $this->meta->pagination;
        return isset($pagination->{$key}) ? $pagination->{$key} : $default;
    }

    private function getLink($link)
    {
        $links = $this->getPagination('links');
        return isset($links->{$link}) ? $links->{$link} : null;
    }
}
