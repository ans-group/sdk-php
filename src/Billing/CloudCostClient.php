<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\CloudCost;
use UKFast\SDK\Billing\Entities\Resource;
use UKFast\SDK\Client as BaseClient;

class CloudCostClient extends BaseClient
{
    protected $basePath = 'billing/';

    const MAP = [
        'server_id' => 'serverId',
        'start_at' => 'startAt',
        'end_at' => 'endAt',
        'next_payment_on' => 'nextPaymentOn',
        'last_payment_at' => 'lastPaymentAt',
    ];

    /**
     * Gets a page of cloud costs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @throws \UKFast\SDK\Exception\UKFastException
     * @return \UKFast\SDK\Page
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

    protected function serializeCloudCost($raw)
    {
        $cloudCost = new CloudCost($this->apiToFriendly($raw, self::MAP));
        $cloudCost->resource = new Resource($raw->resource);
        return $cloudCost;
    }
}
