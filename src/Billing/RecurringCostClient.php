<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\RecurringCost;
use UKFast\SDK\Billing\Entities\Product;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;

class RecurringCostClient extends BaseClient
{
    protected $basePath = 'billing/';

    /**
     * Gets a paginated response of all recurring costs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/recurring-costs', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeRecurringCost($item);
        });

        return $page;
    }

    /**
     * Gets an individual recurring cost
     *
     * @param $id
     * @return RecurringCost
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/recurring-costs/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        $item = $body->data;

        return $this->serializeRecurringCost($item);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addRecurringCost($data)
    {
        $response = $this->post('v1/recurring-costs', json_encode($data));
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->getByName($body->data->name);
    }

    /**
     * @param $item
     * @return RecurringCost
     */
    protected function serializeRecurringCost($item)
    {
        $recurringCost = new RecurringCost($this->apiToFriendly($item, [
            'payment_method' => 'paymentMethod',
            'next_payment_at' => 'nextPaymentAt',
            'created_at' => 'createdAt',
        ]));

        if (!is_null($item->product)) {
            $recurringCost->product = new Product($item->product);
        }

        return $recurringCost;
    }
}
