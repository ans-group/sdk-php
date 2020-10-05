<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\RecurringCost;
use UKFast\SDK\Billing\Entities\RecurringCosts\Partner;
use UKFast\SDK\Billing\Entities\RecurringCosts\Product;
use UKFast\SDK\Billing\Entities\RecurringCosts\Type;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;

class RecurringCostClient extends BaseClient
{
    const MAP = [
        'order_id' => 'orderId',
        'purchase_order_id' => 'purchaseOrderId',
        'cost_centre_id' => 'costCentreId',
        'by_card' => 'byCard',
        'next_payment_at' => 'nextPaymentAt',
        'end_date' => 'endDate',
        'contract_end_date' => 'contractEndDate',
        'frozen_end_date' => 'frozenEndDate',
        'migration_end_date' => 'migrationEndDate',
        'extended_migration_end_date' => 'extendedMigrationEndDate',
        'created_at' => 'createdAt',
        'project_id' => 'projectId'
    ];

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
     * @param $item
     * @return RecurringCost
     */
    protected function serializeRecurringCost($item)
    {
        $recurringCost = new RecurringCost($this->apiToFriendly($item, static::MAP));

        if (isset($item->type)) {
            $recurringCost->type = new Type($item->type);
        }

        if (isset($item->product)) {
            $recurringCost->product = new Product($item->product);
        }

        if (isset($item->partner)) {
            $recurringCost->partner = new Partner($item->partner);
        }

        return $recurringCost;
    }
}
