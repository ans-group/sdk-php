<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client;
use UKFast\SDK\Account\Entities\Product;

class ProductClient extends Client
{
    protected $basePath = 'account/';

    /**
     * Gets a paginated response of all replies to a ticket
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/products", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeProduct($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Reply object
     *
     * @param $item
     * @return \UKFast\SDK\Account\Entities\Product
     */
    protected function serializeProduct($item)
    {
        $product = new Product;
        $product->id = $item->id;
        $product->type = $item->type;
        $product->value = $item->value;

        return $product;
    }
}
