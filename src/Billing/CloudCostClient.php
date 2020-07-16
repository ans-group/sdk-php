<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\CloudCost;
use UKFast\SDK\Billing\Entities\Resource;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;

class CloudCostClient extends BaseClient
{
    protected $basePath = 'billing/';

    const MAP = [
        'server_id'                 => 'serverId',
        'start_at'                  => 'startAt',
        'end_at'                    => 'endAt',
        'next_payment_on'           => 'nextPaymentOn',
        'last_payment_at'           => 'lastPaymentAt',
        'usage_since_last_invoice'  => 'usageSinceLastInvoice',
        'cost_since_last_invoice'   => 'costSinceLastInvoice',
        'usage_for_period_estimate' => 'usageForPeriodEstimate',
        'cost_for_period_estimate'  => 'costForPeriodEstimate',
        'billing_start'             => 'billingStart',
        'billing_end'               => 'billingEnd',
        'billing_due_date'          => 'billingDueDate',
    ];

    const UNITS = [
        'CPU'    => 'Core',
        'GPU'    => 'Core',
        'RAM'    => 'GB',
        'HDD'    => 'GB',
        'OS'     => 'License',
        'CP'     => 'License',
        'SSD'    => 'GB',
        'Backup' => 'GB'
    ];

    /**
     * Gets a page of cloud costs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \UKFast\SDK\Exception\UKFastException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v1/cloud-costs', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeCloudCost($item);
        });

        return $page;
    }

    /**
     * @param $raw
     * @return CloudCost
     */
    protected function serializeCloudCost($raw)
    {
        $cloudCost = new CloudCost($this->apiToFriendly($raw, self::MAP));
        $cloudCost->resource = new Resource($raw->resource);
        return $cloudCost;
    }

    /**
     * @param null $serverId
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTotalCostSinceLastInvoice($serverId = null)
    {
        $optionalParameters = isset($serverId) ? ['serverId' => $serverId] : '';
        $billingItems = $this->getPage(1, 100, $optionalParameters);
        $billingItems = $billingItems->getItems();

        $billingTotals = [];
        foreach ($billingItems as $billingItem) {
            $billingItem = $billingItem->all();

            if (!isset($billingTotals[$billingItem['serverId']])) {
                $billingTotals[$billingItem['serverId']] = [
                    'totalCostSinceLastInvoice' => 0,
                    'totalEstimatedCostForThePeriod' => 0,
                ];
            }

            $billingTotals[$billingItem['serverId']]['totalCostSinceLastInvoice'] +=
                $billingItem['resource']['cost_since_last_invoice'];
            $billingTotals[$billingItem['serverId']]['totalEstimatedCostForThePeriod'] +=
                $billingItem['resource']['cost_for_period_estimate'];
        }
        return $billingTotals;
    }

    /**
     * @param $items
     * @return mixed
     */
    public function showUnits($items)
    {
        foreach ($items as $key => $item) {
            if (array_key_exists($item->resource['type'], self::UNITS)) {
                $items[$key]->resource['quantity'] =
                    $item->resource['quantity'] . ' ' . self::UNITS[$item->resource['type']];

                // Address the plural nouns
                $items[$key]->resource['quantity'] .=
                    in_array($item->resource['type'], ['CPU', 'GPU']) && $item->resource['quantity'] > 1 ? 's' : '';
            }
        }
        return $items;
    }
}
