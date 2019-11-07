<?php

namespace UKFast\SDK\Entities;

interface ClientEntityInterface
{
    /**
     * Load entity from API data
     * @param $data
     * @return mixed
     */
    public function loadEntity($data);
}
